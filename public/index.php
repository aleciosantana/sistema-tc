<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Core\Router;
use App\Controllers\UserController;
use App\Core\AuthMiddleware;

session_start();

$router = new Router();

$router->addMiddleware(new AuthMiddleware(), [], ['/login', '/logout', '/']);

$router->get('/', [HomeController::class, 'index']);

$router->get('/users', [UserController::class, 'index']);
$router->get('/users/create', [UserController::class, 'create']);
$router->post('/users/create', [UserController::class, 'create']);
$router->get('/users/edit/{id}', [UserController::class, 'edit']);
$router->post('/users/edit/{id}', [UserController::class, 'edit']);
$router->post('/users/delete/{id}', [UserController::class, 'delete']);
$router->get('/login', [UserController::class, 'login']);
$router->post('/login', [UserController::class, 'login']);
$router->get('/logout', [UserController::class, 'logout']);

$router->dispatch();
