<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * IIdentity
 * @author Jan Pospisil
 */

interface IIdentity  {

	/**
	 * @return bool true if request is authenticated, false otherwise.
	 */
	public function isLoggedIn();

	public function getId();
}
