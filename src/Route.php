<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Nette\Utils\Strings;

/**
 * Route
 * @author Jan Pospisil
 */

class Route extends \Nette\Object implements IRoute {

	private $pathPattern;
	private $regexp;
	private $method;
	private $className;
	private $vars;
	const SPLITTER = '_______';

	public function __construct($pathPattern, $method, $className){
		$this->pathPattern = $pathPattern;
		preg_match_all('#\<[a-zA-Z0-9]+\>#', $pathPattern, $matches);
		$vars = $matches[0];
		$strtr = array();
		foreach($vars as $var){
			$strtr[$var] = '[a-zA-Z0-9]+';
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
	public function match($path, $method) {
		if($this->method == self::ALL || $method == $this->method || ($method == self::OPTIONS && $this->method == self::POST)){
			if($this->pathPattern == '*'){
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

	public function getPath(){
		return $this->pathPattern;
	}

	private function getPathParameters($path){
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

	public function getMethod(){
		return $this->method;
	}

	public function getClassName(){
		return $this->className;
	}
}
