<?php

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer\Tests;
use RestServer\IRenderer;
use RestServer\Response;

/**
 * TestRenderer
 * @author Jan Pospisil
 */

class TestRenderer extends \Nette\Object implements IRenderer {

	public function send(Response $response) {
		return $response;
	}
}
