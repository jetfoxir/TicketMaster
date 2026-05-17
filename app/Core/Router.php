<?php
namespace App\Core;

class Router
{
    protected $routes = [];

    public function get($uri, $handler)
    {
        $this->routes['GET'][$uri] = $handler;
    }

    public function post($uri, $handler)
    {
        $this->routes['POST'][$uri] = $handler;
    }

    public function dispatch(Request $request)
    {
        $method = $request->getMethod();
        $path = $request->getPath();

        // جستجوی مسیرهای استاتیک
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            return $this->callHandler($handler, []);
        }

        // جستجوی مسیرهای پویا (مثلاً /tickets/{id})
        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                return $this->callHandler($handler, $matches);
            }
        }

        http_response_code(404);
        echo '404 - Page Not Found';
    }

    protected function callHandler($handler, $params)
    {
        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$controller, $method] = explode('@', $handler);
            $controllerClass = "App\\Controllers\\{$controller}";
            $instance = new $controllerClass();
            return call_user_func_array([$instance, $method], $params);
        }
        if (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        }
        throw new \Exception('Invalid route handler');
    }
}