<?php
declare(strict_types = 1);

/**
 * Copyright (c) Jan Pospisil (http://www.jan-pospisil.cz)
 */

namespace RestServer;

/**
 * IRenderer
 * @author Jan Pospisil
 */

interface IRenderer {

	public function send(Response $response): void;

}
