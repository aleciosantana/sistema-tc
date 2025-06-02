<?php
namespace App\Models;

use App\Core\Model;

class OrderItem extends Model
{
    protected static $table = 'order_items';

    protected static $relationships = [
        'order' => [
            'type' => self::BELONGS_TO,
            'model' => Order::class,
            'foreignKey' => 'order_id',
        ],
        'product' => [
            'type' => self::BELONGS_TO,
            'model' => Product::class,
            'foreignKey' => 'product_id',
        ],
    ];
}