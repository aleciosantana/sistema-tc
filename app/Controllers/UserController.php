<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class UserController
{
    public function index()
    {
        $users = User::all();
        View::render('users/index', 'layouts/main', ['users' => $users]);
    }

    public function create()
    {
        $user = new User();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->name = $_POST['name'] ?? '';
            $user->email = $_POST['email'] ?? '';
            $user->role = $_POST['role'] ?? '';
            if (!empty($_POST['password'])) {
                $user->setPassword($_POST['password']);
            }

            $errors = $user->validate();
            if (empty($errors)) {
                if ($user->save()) {
                    header('Location: /users');
                    exit;
                } else {
                    $errors[] = 'Erro ao salvar o usuário.';
                }
            }
            View::render('users/create', 'layouts/main', [
                'errors' => $errors,
                'user' => $user
            ]);
        } else {
            View::render('users/create', 'layouts/main', ['user' => $user]);
        }
    }

    public function edit($params)
    {
        if (!isset($params['id'])) {
            http_response_code(400);
            View::render('errors/400', 'layouts/main', ['message' => 'Parâmetro ID não fornecido']);
            return;
        }

        $user = User::find($params['id']);
        if (!$user) {
            http_response_code(404);
            View::render('errors/404', 'layouts/main');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->name = $_POST['name'] ?? '';
            $user->email = $_POST['email'] ?? '';
            $user->role = $_POST['role'] ?? '';
            if (!empty($_POST['password'])) {
                $user->setPassword($_POST['password']);
            }

            $errors = $user->validate();
            if (empty($errors)) {
                if ($user->save()) {
                    header('Location: /users');
                    exit;
                } else {
                    $errors[] = 'Erro ao atualizar o usuário.';
                }
            }
            View::render('users/edit', 'layouts/main', [
                'user' => $user,
                'errors' => $errors
            ]);
        } else {
            View::render('users/edit', 'layouts/main', [
                'user' => $user
            ]);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = User::authenticate($email, $password);

            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user->id;
                header('Location: /');
                exit;
            } else {
                View::render('users/login', 'layouts/main', [
                    'error' => 'E-mail ou senha inválidos.'
                ]);
            }
        } else {
            View::render('users/login', 'layouts/main');
        }
    }
}