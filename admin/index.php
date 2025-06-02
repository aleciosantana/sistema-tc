<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\AuthMiddleware;
use App\Controllers\DashboardController;
use App\Controllers\AdminController;

session_name('sessao_admin');
session_start();

$router = new Router();

$router->addMiddleware(new AuthMiddleware(), [], ['/login', '/logout', '/']);

$router->get('/', [DashboardController::class, 'index']);

$router->get('/users', [AdminController::class, 'index']);
$router->get('/users/create', [AdminController::class, 'create']);
$router->post('/users/create', [AdminController::class, 'create']);
$router->get('/users/edit/{id}', [AdminController::class, 'edit']);
$router->post('/users/edit/{id}', [AdminController::class, 'edit']);
$router->post('/users/delete/{id}', [AdminController::class, 'delete']);
$router->get('/login', [AdminController::class, 'login']);
$router->post('/login', [AdminController::class, 'login']);
$router->get('/logout', [AdminController::class, 'logout']);


$router->dispatch();