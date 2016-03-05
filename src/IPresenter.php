<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\Http\Request;

/**
 * IPresenter
 * @author Jan Pospisil
 */

interface IPresenter  {
	
	public function run(IParametrs $parameters, Response $response);

}
