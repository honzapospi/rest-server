<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * ParametersAccessor
 * @author Jan Pospisil
 */

class ParametersAccessor extends \Nette\Object {

	private $parameters;

	public function set(IParameters $parameters){
		$this->parameters = $parameters;
	}

	public function get(){
		return $this->parameters;
	}

}
