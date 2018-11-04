<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * IHttpRequest
 * @author Jan Pospisil
 */

interface IParameters  {

	public function post($key = NULL, $isRequired = FALSE, array $validators = []);

	public function file($key = NULL, $isRequired = FALSE, array $validators = []);

	public function get($key = NULL, $isRequired = FALSE, array $validators = []);

	public function path($key, $isRequired = FALSE, array $validators = []);

}
