<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\DashboardController;
use App\Controllers\AdminController;

session_name('sessao_admin');
session_start();

$router = new Router();

$router->get('/', [DashboardController::class, 'index']);
$router->get('/users', [AdminController::class, 'index']);

$router->dispatch();