<?php

/**
 * My Application bootstrap file.
 */
use Nette\Application\Routers\Route;


// Load Nette Framework
require LIBS_DIR . '/Nette/loader.php';
require APP_DIR . '/misc/functions.php';

// Configure application
$configurator = new Nette\Config\Configurator;

// Set a development mode for the domain
// Usefull if you are working with the framework on a shared network
/* if (strpos($_SERVER['HTTP_HOST'], '.mydomain.com') !== false) {
	$configurator->setDebugMode();
} */

// Enable Nette Debugger for error visualisation & logging
$configurator->enableDebugger(__DIR__ . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR)
	->addDirectory(LIBS_DIR)
	->register();

// Set DI container extensions
$configurator->onCompile[] = function($configurator, $compiler) {
	$compiler->addExtension('models', new ModelsExtension);
};

// Create Dependency Injection container from config.neon file
$configurator->addConfig(APP_DIR . '/config/config.neon'/*,
	// Load the config based on debug mode
	$configurator->debugMode ? $configurator::DEVELOPMENT : $configurator::PRODUCTION
*/);
$container = $configurator->createContainer();

// Setup router
$router = $container->router;
$router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

// Configure and run the application!
$container->application->run();
