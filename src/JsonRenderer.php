<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\SmartObject;

/**
 * JsonRenderer
 * @author Jan Pospisil
 */

class JsonRenderer implements IRenderer{
	use SmartObject;

	private $httpResponse;

	public function __construct(\Nette\Http\Response $response){
		$this->httpResponse = $response;
	}

	public function send(Response $response) {
		header('Content-Type: application/json');
		foreach($response->getHeaders() as $name => $value){
			header($name.': '.$value);
		}
		http_response_code($response->getStatusCode());
		$data = json_encode($response->data);
		echo $data;
		die();
	}

}
