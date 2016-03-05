<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Tracy\Debugger;

/**
 * JsonRenderer
 * @author Jan Pospisil
 */

class JsonRenderer extends \Nette\Object implements IRenderer{

	private $httpResponse;

	public function __construct(\Nette\Http\Response $response){
		$this->httpResponse = $response;
	}

	public function send(Response $response) {
		header('Content-Type: application/vnd.api+json');
		foreach($response->getHeaders() as $name => $value){
			header($name.': '.$value);
		}
		http_response_code($response->getStatusCode());
		$data = json_encode($response->data);
		echo $data;
		die();
	}

}
