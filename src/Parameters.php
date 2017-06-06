<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\Http\IRequest;
use Nette\Http\Request;
use Nette\Object;
use Nette\Utils\Strings;


/**
 * Parameters
 * @author Jan Pospisil
 */

class Parameters extends Object implements IParameters {

	/**
	 * @var Request
	 */
	private $request;
	private $pathParameters;
	private $contentType;
	private $validator;

	public function __construct(IRequest $request, array $pathParameters){
		$this->request = $request;
		$this->pathParameters = $pathParameters;
		$this->contentType = isset($request->headers['content-type']) ? $request->headers['content-type'] : 'text/plain';
		$this->validator = new Validator();
	}

	public function post($key = NULL, $isRequired = FALSE, array $validators = array()) {
		if(Strings::substring($this->contentType, 0, 16) == 'application/json'){
			$post = json_decode(file_get_contents('php://input'), TRUE);
			if($key)
				$return = isset($post[$key]) ? $post[$key] : null;
			else
				$return = $post;
		} else {
			if($key)
				$return = $this->request->getPost($key);
			else
				$return = $this->request->getPost();
		}

		$return = $this->validator->validate($key, $isRequired, $validators, $return);
		return $return;
	}

	public function file($key = null, $isRequired = FALSE, array $validators = array()){
		if($key)
			$return = $this->request->getFile($key);
		else
			$return = $this->request->getFiles();
		$return = $this->validator->validate($key, $isRequired, $validators, $return);
		return $return;
	}

	public function get($key = NULL, $isRequired = FALSE, array $validators = array()){
		$return = $this->request->getQuery($key);
		$return = $this->validator->validate($key, $isRequired, $validators, $return);
		return $return;
	}

	public function path($name, $isRequired = FALSE, array $validators = array()){
		$return = array_key_exists($name, $this->pathParameters) ? $this->pathParameters[$name] : null;
		$return = $this->validator->validate($name, $isRequired, $validators, $return);
		return $return;
	}

}
