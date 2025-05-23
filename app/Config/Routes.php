<?php
namespace App\Config;

class Routes
{
    public static function getRoutes()
    {
        return [
            'GET' => [
                '/' => ['controller' => 'HomeController', 'method' => 'index'],
            ],
            // Adicione rotas POST ou outras aqui no futuro
        ];
    }
}