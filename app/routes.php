<?php
use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Controllers\ApiController;

/** @var \Core\Router $router */

$router->get('/', [HomeController::class, 'index']);

// API pro sledování
$router->post('/api/track', [ApiController::class, 'track']);

// Administrace
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/login', [AdminController::class, 'loginForm']);
$router->post('/admin/login', [AdminController::class, 'login']);
$router->get('/admin/logout', [AdminController::class, 'logout']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->post('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/logs', [AdminController::class, 'logs']);
