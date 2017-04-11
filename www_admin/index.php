<?php
/**
 * @package     WebQuin
 *
 * @version     1.0.0
 * @copyright   Copyright (C) 2015 ETD Solutions. Tous droits réservés.
 * @license     http://etd-solutions.com/LICENSE
 * @author      ETD Solutions http://etd-solutions.com
 */

if (version_compare(PHP_VERSION, '7.0', '<')) {
    die('Your host needs to use PHP 7.0 or higher to run this application.');
}
// Define required paths
define('JPATH_CONFIGURATION', JPATH_ROOT . '/App/Config');
define('JPATH_SETUP',         JPATH_ROOT . '/App/Setup');
define('JPATH_TEMPLATES',     JPATH_ROOT . '/App/Templates');

// Constantes de l'application
define('JPATH_BASE', __DIR__);
define('JPATH_ROOT', dirname(__DIR__));
define('JPATH_LOGS', JPATH_ROOT . '/logs');
define('JPATH_FORMS', JPATH_ROOT . '/forms');
define('JPATH_MEDIA', JPATH_BASE . '/media');

// Load the Composer autoloader
require JPATH_ROOT . '/vendor/autoload.php';

$container = new \Joomla\DI\Container;
$container->registerServiceProvider(new \App\Service\ConfigServiceProvider(JPATH_CONFIGURATION . '/config.json'))
	->registerServiceProvider(new \App\Service\DatabaseServiceProvider);

// Instantiate the application.
$application = new \App\App($container);

// Execute the application.
$application->execute();
