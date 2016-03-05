<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer\Tests;
use Nette\Http\IRequest;

/**
 * MockHttpRequest
 * @author Jan Pospisil
 */

class MockHttpRequest extends \Nette\Object implements IRequest {

	public $url;
	public $method;

	function getUrl() {
		// TODO: Implement getUrl() method.
	}

	function getQuery($key = NULL, $default = NULL) {
		// TODO: Implement getQuery() method.
	}

	function getPost($key = NULL, $default = NULL) {
		// TODO: Implement getPost() method.
	}

	function getFile($key) {
		// TODO: Implement getFile() method.
	}

	function getFiles() {
		// TODO: Implement getFiles() method.
	}

	function getCookie($key, $default = NULL) {
		// TODO: Implement getCookie() method.
	}

	function getCookies() {
		// TODO: Implement getCookies() method.
	}

	function getMethod() {
		// TODO: Implement getMethod() method.
	}

	function isMethod($method) {
		// TODO: Implement isMethod() method.
	}

	function getHeader($header, $default = NULL) {
		// TODO: Implement getHeader() method.
	}

	function getHeaders() {
		// TODO: Implement getHeaders() method.
	}

	function isSecured() {
		// TODO: Implement isSecured() method.
	}

	function isAjax() {
		// TODO: Implement isAjax() method.
	}

	function getRemoteAddress() {
		// TODO: Implement getRemoteAddress() method.
	}

	function getRemoteHost() {
		// TODO: Implement getRemoteHost() method.
	}

	function getRawBody() {
		// TODO: Implement getRawBody() method.
	}
}
