<?php

use Controllers\Router\Router;
use Helpers\Psr4AutoloaderClass;
use League\Plates\Engine;

// Create and register our autoloader
require_once __DIR__ . '/Helpers/Psr4AutoloaderClass.php';
$loader = new Psr4AutoloaderClass();
$loader->register();

// Register app namespace<>path bindings
$loader->addNamespace('\\Config', __DIR__ . '/Config');
$loader->addNamespace('\\Controllers', __DIR__ . '/Controllers');
$loader->addNamespace('\\Helpers', __DIR__ . '/Helpers');
$loader->addNamespace('\\Models', __DIR__ . '/Models');

// Register vendors namespace<>path bindings
$loader->addNamespace('\\League\\Plates\\', __DIR__ . '/Vendor/Plates/src');

// Creating the template engine
$engine = new Engine(__DIR__ . '/Views');

// Creating the router
$router = new Router($engine);
// and letting it route the request
$router->routing($_GET, $_POST);
