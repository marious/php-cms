<?php
// Statrt output buffer
ob_start();

// Handle errors for development
ini_set('display_errors', 1);

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

// Turn Off register globals for old php version
ini_set('register_globals', 0);

// Define constants

// Shortcuts
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

// Define domain related constants
define('HOST_NAME', 'http://' . $_SERVER['HTTP_HOST'] . '/cms2/');
define('CSS_DIR', HOST_NAME . 'css/');
define('JS_DIR', HOST_NAME . 'js/');

// Define paths
define('APP_PATH', realpath(dirname(__FILE__)) . DS );
define('MODELS_PATH', APP_PATH . 'models' . DS );
define('LIB_PATH', APP_PATH . 'lib' . DS );
define('ADMIN_VIEWS_PATH', APP_PATH . 'views' .DS . 'admin' . DS );
define('WEB_VIEWS_PATH', APP_PATH . 'views' .DS . 'web' . DS );
define('ADMIN_TEMPLATE_PATH', APP_PATH . 'template' .DS . 'admin' . DS );
define('WEB_TEMPLATE_PATH', APP_PATH . 'template' .DS . 'web' . DS );
define('CSS_PATH', APP_PATH . 'css' . DS);
define('JS_PATH', APP_PATH . 'js' . DS);

// Database Credentials
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'project');
define('DB_USER', 'web');
define('DB_PASS', 'password');

// define salt
define('SALT', 'mykey');

$paths = get_include_path() . PS . LIB_PATH . PS . MODELS_PATH;
set_include_path($paths);

spl_autoload_register(function($class) {
    require_once $class . '.php';
});

$dbh = Database::getInstance();

session_start();
if (preg_match('/admin/i', $_SERVER['REQUEST_URI'])) {
    $template = new adminTemplate();
} else {
    $template = new Template();
}



// End Buffer
ob_flush();