<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * IHttpRequest
 * @author Jan Pospisil
 */

interface IParametrs  {

	public function post($key = NULL);


	public function get($key = NULL, $acceptPost = TRUE);

	public function path($key);

}
