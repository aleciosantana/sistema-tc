<?php
namespace App\Core;

class AuthMiddleware
{
    protected $excludedRoutes;

    public function __construct(array $excludedRoutes = [])
    {
        $this->excludedRoutes = $excludedRoutes;
    }

    public function handle()
    {
        $currentRoute = $_SERVER['REQUEST_URI'];
        $currentRoute = parse_url($currentRoute, PHP_URL_PATH);

        if (in_array($currentRoute, $this->excludedRoutes)) {
            return true;
        }

        if (!isset($_SESSION['auth_id'])) {
            header('Location: /login');
            exit;
        }

        return true;
    }
}