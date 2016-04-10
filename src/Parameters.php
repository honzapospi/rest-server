<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\Http\IRequest;
use Nette\Http\Request;
use Nette\Object;
use Nette\Utils\ArrayHash;
use Nette\Utils\Json;
use Nette\Utils\Strings;
use Tracy\Debugger;

/**
 * Parameters
 * @author Jan Pospisil
 */

class Parameters extends Object implements IParametrs {

	/**
	 * @var Request
	 */
	private $request;
	private $pathParameters;
	private $contentType;

	public function __construct(IRequest $request, array $pathParameters){
		$this->request = $request;
		$this->pathParameters = $pathParameters;
		$this->contentType = isset($request->headers['content-type']) ? $request->headers['content-type'] : 'text/plain';
	}

	public function post($key = NULL) {
		if(Strings::substring($this->contentType, 0, 16) == 'application/json'){
			$post = ArrayHash::from(json_decode(file_get_contents('php://input'), TRUE));
			return isset($post[$key]) ? $post[$key] : null;
		}
		return $this->request->getPost($key);
	}

	public function get($key = NULL, $acceptPost = TRUE){
		$return = $this->request->getQuery($key);
		if(!$return && $acceptPost){
			$return = $this->post($key);
		}
		return $return;
	}

	public function path($name){
		return array_key_exists($name, $this->pathParameters) ? $this->pathParameters[$name] : null;
	}

}
