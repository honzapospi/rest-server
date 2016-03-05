<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer\Exceptions;

/**
 * Error code 401
 * Request is forbidden because of user must be logged in to process this request.
 * AuthenticationException
 * @author Jan Pospisil
 */

class AuthenticationException extends \Exception {


	public function __construct($message = 'User is not logged in.', $code = 0, $previous = null){
		parent::__construct($message, $code, $previous);
	}

}
