<?php
namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public function index()
    {
        // Passa dados para a view, se necessário
        $data = [
            'title' => 'Fábrica de Campeões',
            'message' => 'Gerencie pedidos, produtos, estoque, clientes e entregas de forma eficiente.'
        ];
        
        // Renderiza a view 'home/index' dentro do layout 'layouts/main'
        View::render('home/index', 'layouts/main', $data);
    }
}