<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class HomeController
{
    public function index()
    {
        // Passa dados para a view, se necessário
        $data = [
            'users' => User::all(), // Obtém todos os usuários do modelo User
            'title' => 'Fábrica de Campeões',
            'message' => 'Gerencie pedidos, produtos, estoque, clientes e entregas de forma eficiente.'
        ];
        
        // Renderiza a view 'home/index' dentro do layout 'layouts/main'
        View::render('home/index', 'layouts/main', $data);
    }
}