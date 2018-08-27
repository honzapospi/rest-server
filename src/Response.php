<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

/**
 * Response
 * @author Jan Pospisil
 * @property int $statusCode
 * @property array $data
 */

class Response {
	use SmartObject;

	private $data = array();

	private $statusCode = 200;

	private $headers = array();

	public function setStatusCode($code){
		$this->statusCode = $code;
	}

	public function getStatusCode(): int{
		return $this->statusCode;
	}

	public function setHeader(string $name, $value){
		$this->headers[$name] = $value;
	}

	public function getHeader($name){
		return isset($this->headers[$name]) ? $this->headers[$name] : null;
	}

	public function getHeaders(): array {
		return $this->headers;
	}

	public function getData(){
		return $this->data;
	}

	public function __set($name, $value){
		$this->data[$name] = $value;
	}

}
