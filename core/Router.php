<?php
namespace Core;

class Router {
    private $routes = [];

    public function add($method, $route, $callback) {
        // Convert route to regex
        $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route);
        $routeRegex = "#^" . $routeRegex . "$#";
        
        $this->routes[] = [
            'method' => $method,
            'route' => $routeRegex,
            'callback' => $callback
        ];
    }

    public function get($route, $callback) {
        $this->add('GET', $route, $callback);
    }

    public function post($route, $callback) {
        $this->add('POST', $route, $callback);
    }

    public function dispatch($uri, $method) {
        // Remove query string
        $uri = strtok($uri, '?');
        // Remove trailing slash if not root
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['route'], $uri, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                
                // Call callback
                if (is_callable($route['callback'])) {
                    return call_user_func_array($route['callback'], array_values($params));
                } elseif (is_array($route['callback'])) {
                    // It's [ControllerClass::class, 'method']
                    $controllerName = $route['callback'][0];
                    $methodName = $route['callback'][1];
                    
                    $controller = new $controllerName();
                    return call_user_func_array([$controller, $methodName], array_values($params));
                }
            }
        }

        // 404
        http_response_code(404);
        echo "404 Not Found";
    }
}
