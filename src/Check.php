<?php
namespace RestServer;
use Nette\Utils\Validators;
use RestServer\Exceptions\InvalidParameterException;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * Validators
 * @author Jan Pospisil
 */

class Check extends \Nette\Object {

	const SCALAR = 'SCALAR';
	const INT = 'INT';
	const LENGTH = 'LENGTH';
	const MIN_LENGTH = 'MIN_LENGTH';
	const FLOAT = 'FLOAT';
	const BOOL = 'BOOL';
	const EMAIL = 'EMAIL';
	const IS_ARRAY = 'IS_ARRAY';
}
