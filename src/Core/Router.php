<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $pattern, callable $handler): void
    {
        $this->routes[] = ['pattern' => $pattern, 'handler' => $handler];
    }

    public function dispatch(string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = rtrim($path, '/') ?: '/';

        foreach ($this->routes as $route) {
            $regex = $this->patternToRegex($route['pattern']);
            if (preg_match($regex, $path, $matches)) {
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    private function patternToRegex(string $pattern): string
    {
        $regex = preg_replace('/\{(\w+)\}/', '([^/]+)', $pattern);
        return '#^' . $regex . '$#';
    }
}
