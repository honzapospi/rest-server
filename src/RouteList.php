<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;
use Traversable;

/**
 * RouteList
 * @author Jan Pospisil
 */

class RouteList extends \Nette\Object implements IRoute, \IteratorAggregate{

	private $routes;

	public function add(Route $route){
		$this->routes[] = $route;
	}

	public function match($path, $method){
		foreach($this->routes as $route){
			if($response = $route->match($path, $method)){
				return $response;
			}
		}
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 */
	public function getIterator() {
		return new \ArrayIterator($this->routes);
	}
}
