<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    protected static $table = 'users';
    protected static $relationships = [
        'orders' => [
            'type' => self::HAS_MANY,
            'model' => Order::class,
            'foreignKey' => 'user_id',
            'localKey' => 'id'
        ]
    ];

    public function validate()
    {
        $errors = parent::validate();
        if (empty($this->attributes['email']) || !filter_var($this->attributes['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'O campo e-mail é obrigatório e deve ser válido.';
        }
        if (!isset($this->attributes['id']) && empty($this->attributes['password'])) {
            $errors[] = 'O campo senha é obrigatório para novos usuários.';
        }
        if (empty($this->attributes['role']) || !in_array($this->attributes['role'], ['admin', 'manager', 'employee'])) {
            $errors[] = 'O papel deve ser admin, manager ou employee.';
        }
        return $errors;
    }

    public static function authenticate($email, $password)
    {
        $db = static::getDb();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }

    public function setPassword($password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }
}