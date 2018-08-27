<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\StaticClass;
use Nette\Utils\Validators;
use RestServer\Exceptions\InvalidParameterException;

/**
 * Validators
 * @author Jan Pospisil
 */

class Check {
	use StaticClass;

	const SCALAR = 'SCALAR';
	const INT = 'INT';
	const LENGTH = 'LENGTH';
	const MIN_LENGTH = 'MIN_LENGTH';
	const FLOAT = 'FLOAT';
	const BOOL = 'BOOL';
	const EMAIL = 'EMAIL';
	const IS_ARRAY = 'IS_ARRAY';
}
