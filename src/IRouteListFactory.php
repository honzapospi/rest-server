<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * IRouteListFactory
 * @author Jan Pospisil
 */

interface IRouteListFactory  {

	/**
	 * Create new RoutList
	 * @return mixed
	 */
	public function create(): RouteList;

}
