<?php
namespace App\Core;

class Router
{
    protected $routes = [];
    protected $middlewares = [];

    public function addMiddleware($middleware, $routes = [], $excludedRoutes = [])
    {
        $this->middlewares[] = [
            'middleware' => $middleware,
            'routes' => $routes,
            'excludedRoutes' => $excludedRoutes
        ];
    }

    public function get($path, $handler)
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        $this->addRoute('POST', $path, $handler);
    }

    protected function addRoute($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->middlewares as $middlewareConfig) {
            $middleware = $middlewareConfig['middleware'];
            $routes = $middlewareConfig['routes'];
            $excludedRoutes = $middlewareConfig['excludedRoutes'];

            $applyMiddleware = false;
            if (empty($routes)) {
                $applyMiddleware = true;
            } else {
                foreach ($routes as $route) {
                    if ($this->matchRoute($route, $requestUri)) {
                        $applyMiddleware = true;
                        break;
                    }
                }
            }

            if ($applyMiddleware && !in_array($requestUri, $excludedRoutes)) {
                if (!$middleware->handle()) {
                    return;
                }
            }
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchRoute($route['path'], $requestUri)) {
                $this->handleRoute($route['handler'], $this->extractParams($route['path'], $requestUri));
                return;
            }
        }

        http_response_code(404);
        View::render('errors/404', 'layouts/main');
    }

    protected function matchRoute($routePath, $requestUri)
    {
        $routePath = preg_replace('/{[^}]+}/', '([^/]+)', $routePath);
        $routePath = str_replace('/', '\/', $routePath);
        if (preg_match("/^$routePath$/", $requestUri, $matches)) {
            return true;
        }
        return $routePath === $requestUri;
    }

    protected function extractParams($routePath, $requestUri)
    {
        $params = [];
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts = explode('/', trim($requestUri, '/'));

        foreach ($routeParts as $index => $part) {
            if (preg_match('/^{[^}]+}$/', $part) && isset($uriParts[$index])) {
                $paramName = trim($part, '{}');
                $params[$paramName] = $uriParts[$index];
            }
        }

        return $params;
    }

    protected function handleRoute($handler, $params)
    {
        if (is_callable($handler)) {
            call_user_func($handler, $params);
        } elseif (is_array($handler) && count($handler) === 2) {
            $controller = new $handler[0]();
            $method = $handler[1];
            call_user_func([$controller, $method], $params);
        } else {
            throw new \Exception("Handler inválido");
        }
    }
}