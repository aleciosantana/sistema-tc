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

        // Procura a rota correspondente
        foreach ($this->routes[$method] ?? [] as $routePattern => $route) {
            // Converte o padrão da rota em expressão regular e extrai nomes dos parâmetros
            $paramNames = [];
            $pattern = preg_replace_callback(
                '#\{([a-zA-Z0-9_]+)\}#',
                function ($matches) use (&$paramNames) {
                    $paramNames[] = $matches[1];
                    return '([a-zA-Z0-9_]+)';
                },
                $routePattern
            );
            $pattern = '#^' . $pattern . '$#';

            // Verifica se a URI corresponde ao padrão
            if (preg_match($pattern, $uri, $matches)) {
                $controllerName = 'App\\Controllers\\' . $route['controller'];
                $methodName = $route['method'];

                // Remove o primeiro elemento (a correspondência completa)
                array_shift($matches);

                // Cria array associativo de parâmetros
                $params = [];
                foreach ($paramNames as $index => $name) {
                    if (isset($matches[$index])) {
                        $params[$name] = $matches[$index];
                    }
                }

                // Verifica se o controlador existe
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $methodName)) {
                        // Chama o método com parâmetros apenas se houver parâmetros
                        if (empty($params)) {
                            $controller->$methodName();
                        } else {
                            $controller->$methodName($params);
                        }
                        return;
                    }
                }
            }
        }

        // Rota não encontrada - Exibir 404
        http_response_code(404);
        View::render('errors/404', 'layouts/main');
    }
}