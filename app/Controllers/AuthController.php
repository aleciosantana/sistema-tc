<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Client;

class AuthController
{
    public function showLoginForm()
    {
        View::render('auth/login', 'layouts/main', ['title' => 'Login']);
        
    }
    
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $client = Client::authenticate($email, $password);

        if ($client) {
            $_SESSION['auth_id'] = $client->id;
            header('Location: /');
            exit;
        } else {
            View::render('auth/login', 'layouts/main', [
                'title' => 'Login',
                'error' => 'E-mail ou senha inválidos.'
            ]);
        }
    }

    public function showRegisterForm()
    {
        $client = new Client();

        View::render('auth/register', 'layouts/main', [
            'title' => 'Registrar',
            'client' => $client
        ]);
    }

    public function register()
    {
        $client = new Client();

        $client->name = $_POST['name'] ?? '';
        $client->email = $_POST['email'] ?? '';
        $client->address = $_POST['address'] ?? '';
        if (!empty($_POST['password'])) {
            $client->setPassword($_POST['password']);
        }

        $errors = $client->validate();
        if (empty($errors)) {
            if ($client->save()) {
                $_SESSION['auth_id'] = $client->id;
                header('Location: /');
                exit;
            } else {
                $errors[] = 'Erro ao registrar o cliente.';
            }
        }

        View::render('auth/register', 'layouts/main', [
            'title' => 'Registrar',
            'errors' => $errors,
            'client' => $client
        ]);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
}