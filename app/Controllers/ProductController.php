<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Product;

class ProductController
{
    public function index()
    {
        $products = Product::all();
        View::render('products/index', 'layouts/dashboard', ['title' => 'Produtos', 'products' => $products]);
    }

    public function create()
    {   
        View::render('products/create', 'layouts/dashboard', [
            'title' => 'Criar Produto',
            'product' => new Product()
        ]);
    }

    public function save() {
        $product = new Product();

        $product->name = trim($_POST['name']) ?? '';
        $product->description = $_POST['description'] ?? '';
        $product->price = (float)($_POST['price'] ?? 0);
        $product->stock_quantity = (int)($_POST['stock_quantity'] ?? 0);

        $errors = [];
        if (!$product->name) $errors[] = 'O nome é obrigatório.';
        if ($product->price <= 0) $errors[] = 'O preço deve ser maior que zero.';
        if ($product->stock_quantity < 0) $errors[] = 'A quantidade em estoque não pode ser negativa.';

        if (empty($errors)) {
            if ($product->save()) {
                header('Location: /products');
                exit;
            } else {
                $errors[] = 'Erro ao salvar o produto.';
            }
        }

        View::render('products/create', 'layouts/dashboard', [
            'title' => 'Criar Produto',
            'errors' => $errors,
            'product' => $product
        ]);
    }

    public function edit($params)
    {
        if (!isset($params['id'])) {
            http_response_code(400);
            View::render('errors/400', 'layouts/dashboard', ['message' => 'Parâmetro ID não fornecido']);
            return;
        }

        $product = Product::find($params['id']);
        if (!$product) {
            http_response_code(404);
            View::render('errors/404', 'layouts/dashboard');
            return;
        }

        View::render('products/edit', 'layouts/dashboard', ['title' => 'Editar Produto', 'product' => $product]);
    }

    public function update($params)
    {
        if (!isset($params['id'])) {
            http_response_code(400);
            View::render('errors/400', 'layouts/dashboard', ['message' => 'Parâmetro ID não fornecido']);
            return;
        }

        $product = Product::find($params['id']);
        if (!$product) {
            http_response_code(404);
            View::render('errors/404', 'layouts/dashboard');
            return;
        }

        $product->name = trim($_POST['name']) ?? '';
        $product->description = $_POST['description'] ?? '';
        $product->price = (float)($_POST['price'] ?? 0);
        $product->stock_quantity = (int)($_POST['stock_quantity'] ?? 0);

        $errors = [];
        if (!$product->name) $errors[] = 'O nome é obrigatório.';
        if ($product->price <= 0) $errors[] = 'O preço deve ser maior que zero.';
        if ($product->stock_quantity < 0) $errors[] = 'A quantidade em estoque não pode ser negativa.';

        if (empty($errors)) {
            if ($product->save()) {
                header('Location: /products');
                exit;
            } else {
                $errors[] = 'Erro ao atualizar o produto.';
            }
        }
        View::render('products/edit', 'layouts/dashboard', [
            'title' => 'Editar Produto',
            'errors' => $errors,
            'product' => $product
        ]);
    }

    public function delete($params)
    {
        if (!isset($params['id'])) {
            http_response_code(400);
            View::render('errors/400', 'layouts/dashboard', ['message' => 'Parâmetro ID não fornecido']);
            return;
        }

        $product = Product::find($params['id']);
        if (!$product) {
            http_response_code(404);
            View::render('errors/404', 'layouts/dashboard');
            return;
        }

        if ($product->delete()) {
            header('Location: /products');
            exit;
        } else {
            http_response_code(500);
            View::render('errors/500', 'layouts/dashboard', ['message' => 'Erro ao excluir o produto.']);
        }
    }
}