<?php
namespace App\Config;

class Routes
{
    public static function getRoutes()
    {
        return [
            'GET' => [
                '/' => ['controller' => 'HomeController', 'method' => 'index'],
                '/users' => ['controller' => 'UserController', 'method' => 'index'],
                '/users/create' => ['controller' => 'UserController', 'method' => 'create'],
                '/users/edit/{id}' => ['controller' => 'UserController', 'method' => 'edit'],
                '/login' => ['controller' => 'UserController', 'method' => 'login'],
            ],
            'POST' => [
                '/users/create' => ['controller' => 'UserController', 'method' => 'create'],
                '/users/edit/{id}' => ['controller' => 'UserController', 'method' => 'edit'],
                '/login' => ['controller' => 'UserController', 'method' => 'login'],
            ],
        ];
    }
}