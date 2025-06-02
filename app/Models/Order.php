<?php
namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    protected static $table = 'orders';

    protected static $relationships = [
        'client' => [
            'type' => self::BELONGS_TO,
            'model' => Client::class,
            'foreignKey' => 'client_id',
        ],
        'items' => [
            'type' => self::HAS_MANY,
            'model' => OrderItem::class,
            'foreignKey' => 'order_id',
        ],
    ];
}