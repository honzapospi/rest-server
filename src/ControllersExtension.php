<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;
use Nette\Utils\Strings;;

/**
 * ControllersExtensions
 * @author Jan Pospisil
 */

class ControllersExtension extends CompilerExtension {

	/**
	 * @throws \ReflectionException
	 */
	public function loadConfiguration(): void {
		// TODO: setup
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();
		foreach($config as $name => $classDefinition){
			if(is_scalar($classDefinition)){
				$className = $classDefinition;
				$r = new \ReflectionClass($className);
				if(!$r->implementsInterface('RestServer\IController')){
					throw new \InvalidArgumentException('Class "'.$className.'" must implement interface "RestServer\IController"');
				}
				$builder->addDefinition(strtr(Strings::webalize($className), array('-' => '_')))->setType($className);
			} else {
				$className = $classDefinition['class'];
				$r = new \ReflectionClass($className);
				if(!$r->implementsInterface('RestServer\IController')){
					throw new \InvalidArgumentException('Class "'.$className.'" must implement interface "RestServer\IController"');
				}
				$name = strtr(Strings::webalize($className), array('-' => '_'));
				$def = new ServiceDefinition();
				$def->setType($classDefinition['class']);
				$def->setArguments($classDefinition['arguments']);
				$builder->addDefinition($name, $def);
			}
		}
	}

}
