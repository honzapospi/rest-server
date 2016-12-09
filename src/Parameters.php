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
use RestServer\Exceptions\MissingRequiredParameterException;
use Tracy\Debugger;

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

	public function __construct(IRequest $request, array $pathParameters){
		$this->request = $request;
		$this->pathParameters = $pathParameters;
		$this->contentType = isset($request->headers['content-type']) ? $request->headers['content-type'] : 'text/plain';
	}

	public function post($key = NULL, $isRequired = FALSE) {
		if(Strings::substring($this->contentType, 0, 16) == 'application/json'){
			$post = ArrayHash::from(json_decode(file_get_contents('php://input'), TRUE));
			$return = isset($post[$key]) ? $post[$key] : null;
		} else
			$return = $this->request->getPost($key);
		if(!$return && $isRequired)
			throw new MissingRequiredParameterException('Parameter "'.$key.'" is required.');
		return $return;
	}

	public function get($key = NULL, $isRequired = FALSE){
		$return = $this->request->getQuery($key);
		if(!$return && $isRequired)
			throw new MissingRequiredParameterException('Parameter "'.$key.'" is required.');
		return $return;
	}

	public function path($name, $isRequired = FALSE){
		$return = array_key_exists($name, $this->pathParameters) ? $this->pathParameters[$name] : null;
		if(!$return && $isRequired)
			throw new MissingRequiredParameterException('Parameter "'.$name.'" is required.');
		return $return;
	}

}
