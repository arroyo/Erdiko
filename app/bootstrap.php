<?php
/**
 * Define the project root and load up erdiko's core bootrap
 * You shouldn't have to change anything here unless you are
 * hacking together something unique
 */
define('ERDIKO_ROOT', dirname(__DIR__));
define('ERDIKO_VENDOR', ERDIKO_ROOT.'/vendor');
define('ERDIKO_SRC', ERDIKO_VENDOR.'/erdiko/core/src');
require_once ERDIKO_SRC.'/bootstrap.php';

/**
 * Appstrap
 * Here you can modify safely based on your needs.
 * Add any application defined bootstrap items here
 */
$debug = getenv("ERDIKO_DEBUG");
ini_set('display_errors', $debug);

// To turn on Session (uncomment line below)
// require_once ERDIKO.'/core/session.php';

// Error Management
\erdiko\core\ErrorHandler::init();

/**
 * Hooks
 */
ToroHook::add("404", function ($vars = array()) {
	// Toro::serve Legacy
	$vars['debug'] = \erdiko\core\ErrorHandler::isDebug();
	if (empty($vars['message'])) {
		$vars['message'] = "Sorry, we cannot find that page.";
	}
	if (empty($vars['error'])) {
		$vars['error'] = $vars['message'];
	}
	if (!isset($vars['path_info'])) {
		$vars['path_info'] = "";
	}

	Erdiko::log(\Psr\Log\LogLevel::ERROR, "404 {$vars['path_info']} {$vars['error']}");
	$vars['code'] = 404;

	$theme = new \erdiko\core\Theme( 'bootstrap' );
	$theme->addCss( 'font-awesome',
		'//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
	$theme->addCss( 'font-awesome-animation',
		'/themes/bootstrap/css/font-awesome-animation.css' );

	$response = new \erdiko\core\Response( $theme );
	$response->setContent( \Erdiko::getView('error', $vars) );
	$response->send();
});

ToroHook::add("500", function ($vars = array()) {
	// Toro::serve Legacy
	$vars['debug'] = \erdiko\core\ErrorHandler::isDebug();
	$vars['code'] = 500;
	$vars['message'] = "Sorry, something went wrong.";
	Erdiko::log(\Psr\Log\LogLevel::ERROR, "{$vars['code']}: {$vars['path_info']} {$vars['error']}");

	$theme = new \erdiko\core\Theme( 'bootstrap' );
	$theme->addCss( 'font-awesome',
		'//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
	$theme->addCss( 'font-awesome-animation',
		'/themes/bootstrap/css/font-awesome-animation.css' );

	$response = new \erdiko\core\Response( $theme );
	$response->setContent( \Erdiko::getView('error', $vars) );
	$response->send();
});

// Error management & beautify output.
ToroHook::add("general_error", function ($vars = array()) {
	$vars['debug'] = \erdiko\core\ErrorHandler::isDebug();
	if(!isset($vars['path_info'])){
		$vars['path_info'] = $_SERVER['REQUEST_URI'];
	}
	Erdiko::log(\Psr\Log\LogLevel::ERROR, "{$vars['code']}: {$vars['path_info']} {$vars['error']}");

	$theme = new \erdiko\core\Theme('bootstrap');
	$theme->addCss('font-awesome',
		'//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
	$theme->addCss('font-awesome-animation',
		'/themes/bootstrap/css/font-awesome-animation.css');

	$response = new \erdiko\core\Response($theme);
	$response->setContent(\Erdiko::getView('error', $vars));
	$response->send();
});