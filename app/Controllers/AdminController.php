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
        View::render('admin/index', 'layouts/dashboard', $data);
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
            View::render('admin/create', 'layouts/dashboard', [
                'title' => 'Criar Usuário',
                'errors' => $errors,
                'user' => $user
            ]);
        } else {
            View::render('admin/create', 'layouts/dashboard', ['title' => 'Criar Usuário', 'user' => $user]);
        }
    }

    public function edit($params)
    {
        if (!isset($params['id'])) {
            http_response_code(400);
            View::render('errors/400', 'layouts/dashboard', ['message' => 'Parâmetro ID não fornecido']);
            return;
        }

        $user = User::find($params['id']);
        if (!$user) {
            http_response_code(404);
            View::render('errors/404', 'layouts/dashboard');
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
            View::render('admin/edit', 'layouts/dashboard', [
                'title' => 'Editar Usuário',
                'user' => $user,
                'errors' => $errors
            ]);
        } else {
            View::render('admin/edit', 'layouts/dashboard', [
                'title' => 'Editar Usuário',
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
                $_SESSION['user_id'] = $user->id;
                header('Location: /');
                exit;
            } else {
                View::render('admin/login', 'layouts/dashboard', [
                    'title' => 'Login',
                    'error' => 'E-mail ou senha inválidos.'
                ]);
            }
        } else {
            View::render('admin/login', 'layouts/dashboard', ['title' => 'Login']);
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }

    public function delete($params)
    {
        if (!isset($params['id'])) {
            http_response_code(400);
            View::render('errors/400', 'layouts/dashboard', ['message' => 'Parâmetro ID não fornecido']);
            return;
        }

        $user = User::find($params['id']);
        if (!$user) {
            http_response_code(404);
            View::render('errors/404', 'layouts/dashboard');
            return;
        }

        if ($user->delete()) {
            $users = User::all();
            View::render('admin/index', 'layouts/dashboard', [
                'title' => 'Usuários',
                'users' => $users,
                'success' => 'Usuário excluído com sucesso.'
            ]);
        } else {
            $users = User::all();
            View::render('admin/index', 'layouts/dashboard', [
                'title' => 'Usuários',
                'users' => $users,
                'error' => 'Erro ao excluir o usuário.'
            ]);
        }
    }
}