<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use RestServer\Exceptions\ApplicationException;
use Nette\Http\Request;
use Nette\DI\Container;
use RestServer\Exceptions\AuthenticationException;
use RestServer\Exceptions\BadRequestException;
use RestServer\Exceptions\DataException;
use RestServer\Exceptions\ForbiddenRequestException;
use RestServer\Exceptions\InvalidRequestException;
use Tracy\Debugger;

/**
 * Application
 *
 * 400 - BadRequestException - Programmer error. Programmer should log this error and repair it.
 * 401 - AuthenticationException - User just now trying to login with invalid credentials, or user is not logged in and page is only for logged in user.
 *   This can happen if access token expired. On client user should be ask for valid credentials, logged in and then try t again.
 * 404 - DataException - Record not found in database or has wrong value
 * 403 - ForbiddenRequestException - Someone try something nasty. User is logged in and try to do something which is not approved.
 *
 * @author Jan Pospisil
 */

class Application extends \Nette\Object {

	private $routeList;
	private $request;
	private $responseFactory;
	private $container;
	private $renderer;

	/**
	 * Event executed just before run presenter
	 * @var array
	 */
	public $onBeforeRun = array();

	public $catchExceptions = TRUE;

	public function __construct(IRouteListFactory $routeListFactory, Request $request, IResponseFactory $responseFactory, Container $container, IRenderer $renderer){
		$this->routeList = $routeListFactory->create();
		$this->request = $request;
		$this->responseFactory = $responseFactory;
		$this->container = $container;
		$this->catchExceptions = Debugger::$productionMode;
		$this->renderer = $renderer;
	}

	public function run(){
		try {
			$path = substr($this->request->url->path, strlen($this->request->url->basePath) - 1);
			// accept /?path=/endpoint AND index.php?path=/endpoint
			if($path == '/' || $path == '/index.php' && $this->request->getQuery('path'))
				$path = $this->request->getQuery('path');
			$path = $path ? $path : '/';
			$routeResponse = $this->routeList->match($path, $this->request->method);
			if(!$routeResponse)
				throw new BadRequestException('Unsupported '.$this->request->method.' "'.$path.'"" request');
			$instance = $this->container->getByType($routeResponse['classname']);
			if(!$instance instanceof IController) {
				throw new ApplicationException('Class "' . $routeResponse['classname'] . '" must be instance of RestServer\IController');
			}
			$response = $this->responseFactory->create();
			$this->onBeforeRun($this, $instance, $routeResponse['pathParameters']);
			$instance->run(new Parameters($this->request, $routeResponse['pathParameters']), $response);

		} catch (BadRequestException $e){
			$this->renderException($e, 400);
		} catch (AuthenticationException $e){
			$this->renderException($e, 401);
		} catch (DataException $e){
			$this->renderException($e, 404);
		} catch (ForbiddenRequestException $e){
			$this->renderException($e, 403);
		} catch (\Exception $e){
			//Debugger::log($e);
			$this->renderException($e, 500);
		}
		return $this->renderer->send($response);
	}

	private function renderException(\Exception $e, $code){
		Debugger::log($e->getMessage(), $code);
		if($this->catchExceptions){
			$response = $this->responseFactory->create();
			$error = array(
				'message' => $e->getMessage()
			);
			$response->error = array($error);
			$response->setStatusCode($code);
			$this->renderer->send($response);
		} else {
			throw $e;
		}
	}

}
