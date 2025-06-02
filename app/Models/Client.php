<?php

namespace App\Models;

use App\Core\Model;
use App\Contracts\Authenticatable;
use App\Traits\Authenticatable as AuthenticatableTrait;

class Client extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected static $table = 'clients';

    protected static $relationships = [
        'orders' => [
            'type' => self::HAS_MANY,
            'model' => Order::class,
            'foreignKey' => 'client_id',
        ],
    ];
}