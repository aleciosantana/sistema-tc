<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class AdminController
{
    public function index()
    {
        $users = User::all();

        $data = [
            'title' => 'Usuários Admin',
            'users' => $users
        ];
        View::render('admin/index', 'layouts/main', $data);
    }
}