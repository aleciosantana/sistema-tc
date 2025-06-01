<?php
namespace App\Controllers;

use App\Core\View;

class DashboardController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'message' => 'Bem-vindo ao painel administrativo!'
        ];
        View::render('dashboard/index', 'layouts/dashboard', $data);
    }
}