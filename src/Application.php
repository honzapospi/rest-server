<?php
declare(strict_types=1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

use Nette\SmartObject;
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
class Application
{
	use SmartObject;

	private $routeList;
	private $request;
	private $responseFactory;
	private $container;
	private $renderer;
	private $parametersAccessor;

	/**
	 * Event executed just before run presenter
	 * @var array
	 */
	public $onBeforeRun = array();

	public $catchExceptions = TRUE;

	public function __construct(IRouteListFactory $routeListFactory, Request $request, IResponseFactory $responseFactory, Container $container, IRenderer $renderer, ParametersAccessor $parametersAccessor)
	{
		$this->routeList = $routeListFactory->create();
		$this->request = $request;
		$this->responseFactory = $responseFactory;
		$this->container = $container;
		$this->catchExceptions = Debugger::$productionMode;
		$this->renderer = $renderer;
		$this->parametersAccessor = $parametersAccessor;
	}

	public function run():void
	{
		try {
			$path = substr($this->request->url->path, strlen($this->request->url->basePath) - 1);
			// accept /?path=/endpoint AND index.php?path=/endpoint
			if ($path == '/' || $path == '/index.php' && $this->request->getQuery('path'))
				$path = $this->request->getQuery('path');
			$path = $path ? $path : '/';
			$routeResponse = $this->routeList->match($path, $this->request->method);
			if (!$routeResponse)
				throw new BadRequestException('Unsupported ' . $this->request->method . ' ' . $path . ' request');
			$instance = $this->container->getByType($routeResponse['classname']);
			if (!$instance instanceof IController) {
				throw new ApplicationException('Class "' . $routeResponse['classname'] . '" must be instance of RestServer\IController');
			}
			$response = $this->responseFactory->create();
			$this->onBeforeRun($this, $instance, $routeResponse['pathParameters']);
			$parameters = new Parameters($this->request, $routeResponse['pathParameters']);
			$this->parametersAccessor->set($parameters);
			$instance->run($parameters, $response);

		} catch (BadRequestException $e) {
			$this->renderException($e, 400);
		} catch (AuthenticationException $e) {
			$this->renderException($e, 401);
		} catch (DataException $e) {
			$this->renderException($e, 404);
		} catch (ForbiddenRequestException $e) {
			$this->renderException($e, 403);
		} catch (\Exception $e) {
			$this->renderException($e, 500);
		}
		$this->renderer->send($response);
	}

	private function renderException(\Exception $e, int $code): void
	{
		Debugger::log($e->getMessage(), $code);
		if ($code >= 500)
			Debugger::log($e);
		if ($this->catchExceptions) {
			$response = $this->responseFactory->create();
			$error = array(
				'message' => $code < 500 ? $e->getMessage() : 'Internal server error.'
			);
			$response->error = $error;
			$response->setStatusCode($code);
			$this->renderer->send($response);
		} else {
			throw $e;
		}
	}

}
