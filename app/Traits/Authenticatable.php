<?php
namespace App\Traits;

use PDO;

trait Authenticatable
{
    public static function authenticate($email, $password)
    {
        $db = static::getDb();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE email = :email");
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