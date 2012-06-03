<?php

// absolute filesystem path to this web root
define('WWW_DIR', __DIR__);

// absolute filesystem path to base dir
define('BASE_DIR', realpath(WWW_DIR . '/..'));

// absolute filesystem path to the application root
define('APP_DIR', realpath(WWW_DIR . '/../app'));

// absolute filesystem path to the libraries
define('LIBS_DIR', realpath(WWW_DIR . '/../libs'));

// uncomment this line if you must temporarily take down your site for maintenance
// require APP_DIR . '/templates/maintenance.phtml';

// load bootstrap file
$bootstrap = require APP_DIR . '/bootstrap.php';
$bootstrap->application->run();