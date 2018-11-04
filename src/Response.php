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
 * @property-write int $statusCode
 */

class Response {
	use SmartObject;

	private $data = array();

	/**
	 * http status code (https://en.wikipedia.org/wiki/List_of_HTTP_status_codes)
	 * @var int
	 */
	private $statusCode = 200;

	private $headers = array();

	/**
	 * Set http status code
	 * @param $code
	 */
	public function setStatusCode($code): void{
		$this->statusCode = $code;
	}

	/**
	 * Get http status code
	 * @internal
	 * @return int
	 */
	public function getStatusCode(): int{
		return $this->statusCode;
	}

	/**
	 * Set header by name
	 * @param string $name
	 * @param $value
	 */
	public function setHeader(string $name, $value): void{
		$this->headers[$name] = $value;
	}

	/**
	 * Get specific header
	 * @param $name
	 * @return mixed|null
	 */
	public function getHeader($name){
		return isset($this->headers[$name]) ? $this->headers[$name] : null;
	}

	/**
	 * Get all headers
	 * @return array
	 */
	public function getHeaders(): array {
		return $this->headers;
	}

	/**
	 * Get response data to be render
	 * @internal
	 * @return array
	 */
	public function getData():array{
		return $this->data;
	}

	/**
	 * Set value for response
	 * @param $name
	 * @param $value
	 */
	public function __set($name, $value){
		$this->data[$name] = $value;
	}

}
