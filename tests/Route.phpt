<?php

use RestServer\Route;
use Tester\Assert;

require __DIR__.'/bootstrap.php';

$route = new Route('/user/<username>/detail', Route::GET, 'x');
Assert::type('array', $route->match('/user/10/detail', Route::GET));

$route = new Route('/user/<username>/detail', Route::GET, 'x');
Assert::type('array', $route->match('/user/jksdhk.ksjd-dskjlf/detail', Route::GET));

