<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * IHttpRequest
 * @author Jan Pospisil
 */

interface IParameters  {

	public function post($key = NULL, $isRequired = FALSE, array $validators = null);

	public function file($key = NULL, $isRequired = FALSE, array $validators = null);

	public function get($key = NULL, $isRequired = FALSE, array $validators = null);

	public function path($key, $isRequired = FALSE, array $validators = null);

}
