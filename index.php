<?php

use Controllers\Router\Router;
use Exceptions\IRenderableException;
use Helpers\Logger;
use Helpers\Psr4AutoloaderClass;
use League\Plates\Engine;

session_start();

// Create and register our autoloader
require_once __DIR__ . '/Helpers/Psr4AutoloaderClass.php';
$loader = new Psr4AutoloaderClass();
$loader->register();

// Register app namespace<>path bindings
$loader->addNamespace('\\Config', __DIR__ . '/Config');
$loader->addNamespace('\\Controllers', __DIR__ . '/Controllers');
$loader->addNamespace('\\Exceptions', __DIR__ . '/Exceptions');
$loader->addNamespace('\\Helpers', __DIR__ . '/Helpers');
$loader->addNamespace('\\Models', __DIR__ . '/Models');
$loader->addNamespace('\\Services', __DIR__ . '/Services');

// Register vendors namespace<>path bindings
$loader->addNamespace('\\League\\Plates\\', __DIR__ . '/Vendor/Plates/src');

// Creating the template engine
$engine = new Engine(__DIR__ . '/Views');

// Creating the logging system
$logger = new Logger(__DIR__ . '/logs');

// Creating the router
$router = new Router($engine, $logger);
try {
	// and letting it route the request
	$router->routing($_GET, $_POST);
} catch (IRenderableException $e) {
	// use the class method to render the exception
	$e->render($engine);
}
