<?php
namespace RestServer;

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 * Validator
 * @author Jan Pospisil
 */

class Validator extends \Nette\Object {

	public function validate($name, $isRequired, array $validators, $value){
		if(!$value && $isRequired)
			throw new MissingRequiredParameterException('Parameter "'.$name.'" is required.');
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
				if(!Strings::length($value) != $validatorVal)
					throw new InvalidParameterException('Parameter "'.$name.'" must be exactly '.$validatorVal.' chars length.');
			} elseif($validator == Check::MIN_LENGTH){
				if(Strings::length($value) < $validatorVal)
					throw new InvalidParameterException('Parameter "'.$name.'" must be at least '.$validatorVal.' chars length.');
			}

			else {
				throw new \RuntimeException('Invalid validator '.$validator);
			}
		}
		return $value;
	}

}
