<?php

class Router
{
    private static $routes = [];

    public static function add($method, $path, $callback)
    {
        self::$routes[$method][$path] = $callback;
    }

    public static function get($path, $callback)
    {
        self::add('GET', $path, $callback);
    }

    public static function post($path, $callback)
    {
        self::add('POST', $path, $callback);
    }

    public static function put($path, $callback)
    {
        self::add('PUT', $path, $callback);
    }

    public static function delete($path, $callback)
    {
        self::add('DELETE', $path, $callback);
    }

    public static function resolve($uri, $method)
    {
        $methodRoutes = self::$routes[$method] ?? [];

        foreach ($methodRoutes as $route => $callback) {

            // Convert /clients/{id} → regex
            $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '(\d+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);

                return call_user_func_array($callback, $matches);
            }
        }

        echo json_encode([
            "status" => "error",
            "message" => "Route not found"
        ]);
        exit;
    }
}