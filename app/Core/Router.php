<?php
namespace App\Core;

use App\Config\Routes;

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = Routes::getRoutes();
    }

    public function dispatch()
    {
        // Obtém o método HTTP e a URI
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove a pasta base, se necessário (ex.: /sistema-tc/)
        $basePath = '/';
        if ($basePath !== '/' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Normaliza a URI: garante que a raiz seja '/' e remove barras finais
        $uri = ($uri === '' || $uri === '/') ? '/' : rtrim($uri, '/');

        // Verifica se a rota existe
        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            $controllerName = 'App\\Controllers\\' . $route['controller'];
            $methodName = $route['method'];

            // Verifica se o controlador existe
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                    return;
                }
            }
        }

        // Rota não encontrada - Exibir 404
        http_response_code(404);
        View::render('errors/404', 'layouts/main');
    }
}