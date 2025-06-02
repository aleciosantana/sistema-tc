<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Product;
use App\Models\Order;

class SaleController
{
    public function show($params) {
        $product = Product::find($params['id']);
        if (!$product) {
            header('HTTP/1.0 404 Not Found');
            echo "Produto não encontrado.";
            exit;
        }

        $otherProducts = array_filter(Product::all(), function($p) use ($product) {
            return $p->id !== $product->id && $p->stock_quantity > 0;
        });

        $data = [
            'title' => $product->name,
            'product' => $product,
            'otherProducts' => $otherProducts
        ];
        View::render('sale/show', 'layouts/main', $data);
    }

    public function addToCart()
    {
        // Recebe o ID do produto e a quantidade via POST
        $productId = $_POST['product_id'] ?? null;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if (!$productId || $quantity < 1) {
            $_SESSION['flash'] = 'Produto ou quantidade inválida.';
            header('Location: /produtos');
            exit;
        }

        $product = Product::find($productId);

        if (!$product) {
            $_SESSION['flash'] = 'Produto não encontrado.';
            header('Location: /produtos');
            exit;
        }

        // Verifica estoque disponível
        if ($product->stock_quantity < $quantity) {
            $_SESSION['flash'] = 'Estoque insuficiente.';
            header('Location: /produtos/' . $productId);
            exit;
        }

        // Inicializa o carrinho se não existir
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Adiciona ou incrementa a quantidade do produto no carrinho
        if (isset($_SESSION['cart'][$productId])) {
            $novaQuantidade = $_SESSION['cart'][$productId] + $quantity;
            if ($novaQuantidade > $product->stock_quantity) {
                $_SESSION['flash'] = 'Quantidade solicitada excede o estoque.';
                header('Location: /produtos/' . $productId);
                exit;
            }
            $_SESSION['cart'][$productId] = $novaQuantidade;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }

        $_SESSION['flash'] = 'Produto adicionado ao carrinho!';
        header('Location: /cart');
        exit;
    }

    public function cart()
    {
        $items = [];
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id => $qty) {
                $product = Product::find($id);
                $items[] = ['product' => $product, 'quantity' => $qty];
            }
        }

        $data = [
            'title' => 'Cart',
            'items' => $items
        ];
        View::render('sale/cart', 'layouts/main', $data);
    }

    public function checkout()
    {
        // Verifica se o cliente está logado
        if (empty($_SESSION['auth_id'])) {
            $_SESSION['flash'] = 'Você precisa estar logado para finalizar a compra.';
            header('Location: /login');
            exit;
        }

        // Verifica se o carrinho está vazio
        if (empty($_SESSION['cart'])) {
            $_SESSION['flash'] = 'Seu carrinho está vazio.';
            header('Location: /cart');
            exit;
        }

        $clientId = $_SESSION['auth_id'];
        $cart = $_SESSION['cart'];

        // Cria o pedido
        $order = Order::create([
            'client_id' => $clientId,
            'status' => 'pending'
        ]);

        if (!$order) {
            $_SESSION['flash'] = 'Erro ao criar pedido.';
            header('Location: /cart');
            exit;
        }

        // Adiciona os itens ao pedido
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if (!$product || $product->stock_quantity < $quantity) {
                $_SESSION['flash'] = 'Produto sem estoque suficiente: ' . ($product ? $product->name : 'ID ' . $productId);
                header('Location: /cart');
                exit;
            }

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price
            ]);

            // Atualiza o estoque
            $product->stock_quantity -= $quantity;
            $product->save();
        }

        // Limpa o carrinho
        unset($_SESSION['cart']);

        $_SESSION['flash'] = 'Compra finalizada com sucesso!';
        header('Location: /order/success?id=' . $order->id);
        exit;
    }

    public function success()
    {
        $data = ['title' => 'Pedido realizado'];
        View::render('sale/success', 'layouts/main', $data);
    }
}