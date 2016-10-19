<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\DI\CompilerExtension;
use Nette\Utils\Strings;

/**
 * ControllersExtensions
 * @author Jan Pospisil
 */

class ControllersExtension extends CompilerExtension {

	public function loadConfiguration(){
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();
		foreach($config as $name => $className){
			$r = new \ReflectionClass($className);
			if(!$r->implementsInterface('RestServer\IController')){
				throw new \InvalidArgumentException('Class "'.$className.'" must implement interface "RestServer\IController"');
			}
			$builder->addDefinition(strtr(Strings::webalize($className), array('-' => '_')))->setClass($className);
		}
	}

}
