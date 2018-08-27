<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * IRoute
 * @author Jan Pospisil
 */

interface IRoute {

	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const DELETE = 'DELETE';
	const ALL = 'ALL';
	const OPTIONS = 'OPTIONS';

	/**
	 * @param $path
	 * @return string ClassName is success, false otherwise.
	 */
	public function match(string $path,string $method);

}
