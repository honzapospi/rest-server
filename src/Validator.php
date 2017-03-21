<?php
namespace RestServer;
use Nette\Caching\Cache;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use RestServer\Exceptions\InvalidParameterException;
use RestServer\Exceptions\MissingRequiredParameterException;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * Validator
 * @author Jan Pospisil
 */

class Validator extends \Nette\Object {

	public function validate($name, $isRequired, array $validators, $value){
		if(!$value && $isRequired)
			throw new MissingRequiredParameterException('Parameter "'.$name.'" is required.');
		if(!$value && !$isRequired)
			return null;
		if(!$validators)
			return $value;
		if($value === null && !$isRequired)
			return $value;
		foreach($validators as $validatorName => $validatorVal){
			$validator = is_int($validatorName) ? $validatorVal : $validatorName;
			if($validator == Check::SCALAR){
				if(!is_scalar($value))
					throw new InvalidParameterException('Parameter "'.$name.'" must be scalar.');
			} elseif($validator == Check::INT){
				if(!Validators::isNumericInt($value))
					throw new InvalidParameterException('Parameter "'.$name.'" must be int.');
				$value = (int) $value;
			} elseif($validator == Check::LENGTH){
				if(Strings::length($value) != $validatorVal)
					throw new InvalidParameterException('Parameter "'.$name.'" must be exactly '.$validatorVal.' chars length.');
			} elseif($validator == Check::MIN_LENGTH){
				if(Strings::length($value) < $validatorVal)
					throw new InvalidParameterException('Parameter "'.$name.'" must be at least '.$validatorVal.' chars length.');
			} elseif($validator == Check::FLOAT){
				$value = strtr($value, array(',' => '.'));
				if(!Validators::isNumeric($value))
					throw new InvalidParameterException('Parameter "'.$name.'" must be float.');
				$value = (float) $value;
			} elseif($validator == Check::BOOL){
				if(!is_bool($value) && $value != 1 && $value != 0)
					throw new InvalidParameterException('Parameter "'.$name.'" must be boolean.');
				$value = (bool) $value;
			} elseif($validator == Check::EMAIL){
				if(!Validators::isEmail($value)){
					throw new InvalidParameterException('Parameter "'.$name.'" must be email.');
				}
			} elseif($validator == Check::IS_ARRAY){
				if(!is_array($value))
					throw new InvalidParameterException('Parameter "'.$name.'" is not array.');
			}

			else {
				throw new \RuntimeException('Invalid validator '.$validator);
			}
		}
		return $value;
	}

}
