<?php

use Controllers\MainController;
use Helpers\Psr4AutoloaderClass;
use League\Plates\Engine;

// Create and register our autoloader
require_once __DIR__ . '/Helpers/Psr4AutoloaderClass.php';
$loader = new Psr4AutoloaderClass();
$loader->register();

// Register app namespace<>path bindings
$loader->addNamespace('\\Controllers', __DIR__ . '/Controllers');
$loader->addNamespace('\\Helpers', __DIR__ . '/Helpers');

// Register vendors namespace<>path bindings
$loader->addNamespace('\\League\\Plates\\', __DIR__ . '/Vendor/Plates/src');

// Creating the template engine
$engine = new Engine(__DIR__ . '/Views');

// Creating the main controller
$controller = new MainController($engine);
// and rendering the index page
$controller->index();
