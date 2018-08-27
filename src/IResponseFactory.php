<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * IResponseFactory
 * @author Jan Pospisil
 */

interface IResponseFactory  {

	/**
	 * @return Response
	 */
	public function create();
	
}
