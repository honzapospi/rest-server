<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\SmartObject;

/**
 * ParametersAccessor
 * @author Jan Pospisil
 */

class ParametersAccessor {
	use SmartObject;

	private $parameters;

	public function set(IParameters $parameters) {
		$this->parameters = $parameters;
	}

	/**
	 * @return IParameters
	 */
	public function get(): IParameters {
		return $this->parameters;
	}

}
