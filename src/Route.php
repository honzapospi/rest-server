<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\SmartObject;
use Nette\Utils\Strings;

/**
 * Route
 * @author Jan Pospisil
 */

class Route implements IRoute {
	use SmartObject;

	private $pathPattern;
	private $regexp;
	private $method;
	private $className;
	private $vars;

	public function __construct($pathPattern, $method, $className){
		$pathPattern = rtrim($pathPattern, '/');
		$this->pathPattern = $pathPattern;
		preg_match_all('#\<[a-zA-Z0-9]+\>#', $pathPattern, $matches);
		$vars = $matches[0];
		$strtr = array();
		foreach($vars as $var){
			$strtr[$var] = '[a-zA-Z0-9._-]+';
		}
		$this->vars = $vars;
		$this->regexp = strtr($pathPattern, $strtr);
		$this->method = $method;
		$this->className = $className;
	}

	/**
	 * @param $path
	 * @return string ClassName is success, false otherwise.
	 */
	public function match(string $path, string $method) {
		$path = rtrim($path, '/');
		if($this->method == self::ALL || $method == $this->method || $method == self::OPTIONS){
			if($this->pathPattern === '*'){
				if($method == self::OPTIONS)
					die('access');
				return array(
					'pathParameters' => array('path' => $path),
					'classname' => $this->className
				);
			} elseif(preg_match('#^'.$this->regexp.'$#', $path)){
				if($method == self::OPTIONS)
					die('access');
				return array(
					'pathParameters' => $this->getPathParameters($path),
					'classname' => $this->className
				);
			}
		}
	}

	/**
	 * Get current path
	 * @return string
	 */
	public function getPath(): string{
		return $this->pathPattern;
	}

	private function getPathParameters($path): array{
		$parts = explode('/', $path);
		$parts2 = explode('/', $this->pathPattern);
		$return = array();
		foreach($parts2 as $i => $varName){
			if(in_array($varName, $this->vars)){
				$return[trim($varName, '<>')] = $parts[$i];
			}
		}
		return $return;
	}

	/**
	 * @return string GET|POST|PUT|DELETE|OPTIONS
	 */
	public function getMethod(): string {
		return $this->method;
	}

	/**
	 * Return className
	 * @return string
	 */
	public function getClassName(): string{
		return $this->className;
	}
}
