<?php
namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    protected static $table = 'products';

    public function updateStock($quantity)
    {
        if ($this->stock_quantity >= $quantity) {
            $this->stock_quantity -= $quantity;
            $sql = "UPDATE {static::table} SET stock_quantity = :stock_quantity WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':stock_quantity' => $this->stock_quantity,
                ':id' => $this->id
            ]);
            return true;
        }
        return false;
    }
}