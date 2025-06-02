<?php
namespace App\Contracts;

interface Authenticatable
{
    public static function authenticate($email, $password);
    public function setPassword($password);
}
