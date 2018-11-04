<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\Http\Request;

/**
 * IPresenter
 * @author Jan Pospisil
 */

interface IController  {
	
	public function run(IParameters $parameters, Response $response): void;

}
