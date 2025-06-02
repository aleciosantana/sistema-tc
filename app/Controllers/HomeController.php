<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Models\Product;

class HomeController
{
    public function index()
    {
        $products = array_filter(Product::all(), function ($product) {
            return $product->stock_quantity > 0;
        });
        
        return View::render('home/index', 'layouts/main', [
            'products' => $products,
            'title' => 'Fábrica de Campeões',
            'message' => 'Gerencie pedidos, produtos, estoque, clientes e entregas de forma eficiente.'
        ]);
    }
}