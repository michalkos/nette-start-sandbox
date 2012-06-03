<?php

use Nette\Application\Routers\Route;

// Load Nette Framework
require LIBS_DIR . '/Nette/loader.php';
require APP_DIR . '/misc/functions.php';
require APP_DIR . '/misc/Bootstrap.php';

// Create bootstrap
$bootstrap = new Bootstrap;
$container = $bootstrap->createContainer();

// Setup router
$router = $container->router;
$router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

return $container;
