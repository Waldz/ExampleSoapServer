<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Define application environment (production|staging|testing|development)
defined('APPLICATION_ENV') ||
    define('APPLICATION_ENV', ((getenv('APP_ENV')) ? getenv('APP_ENV') : 'development'));

define('REQUEST_MICROTIME', microtime(true));

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
