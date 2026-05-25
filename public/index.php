<?php
session_start();

// Autoloader
spl_autoload_register(function ($class) {
    // Core\Router -> core/Router.php
    // App\Controllers\HomeController -> app/Controllers/HomeController.php
    
    $prefix = '';
    $base_dir = __DIR__ . '/../';

    if (strpos($class, 'Core\\') === 0) {
        $prefix = 'Core\\';
        $base_dir .= 'core/';
    } elseif (strpos($class, 'App\\') === 0) {
        $prefix = 'App\\';
        $base_dir .= 'app/';
    }
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

use Core\Router;

$router = new Router();

// Zavedeme routy
require __DIR__ . '/../app/routes.php';

// Dispatch
$uri = $_SERVER['REQUEST_URI'];
// Odstranění /public z URI pokud se tam nachází (v závislosti na .htaccess nastavení)
$uri = str_replace('/public', '', $uri);
if ($uri === '') $uri = '/';

$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);
