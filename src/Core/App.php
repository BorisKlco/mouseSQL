<?php

namespace Core;

use Core\Router;

class App
{
    private static Router $router;

    public function __construct()
    {
        self::$router = new Router();
        require_once BASE_PATH . 'routes.php';
        require_once BASE_PATH . 'Helper/helpers.php';
    }

    public static function resolve(string $uri, string $method): void
    {
        self::$router->resolve($uri, $method);
    }

    public static function get(string $route, callable|array $action): Router
    {
        return self::$router->register('GET', $route, $action);
    }

    public static function post(string $route, callable|array $action): Router
    {
        return self::$router->register('POST', $route, $action);
    }
    /**
     * Checks if a specific path matches a named route.
     *
     * @param string $path The request path to check against.
     * @param string $name The name of the route to compare with.
     * @return bool Returns true if the path matches the named route, false otherwise.
     */
    public static function isRoute(string $path, string $name): bool
    {
        $routes = self::$router->routes;
        foreach ($routes as $route) {
            if ($route['path'] == $path && $route['routeName'] == $name) {
                return true;
            }
        }
        return false;
    }
    /**
     * Retrieves the path for a named route.
     *
     * @param string $name The name of the route to retrieve the path for.
     * @return string Returns the URL path for the specified route, or 'RouteNameNotFound' if not found.
     */
    public static function getRoute(string $name): string
    {
        $routes = self::$router->routes;
        foreach ($routes as $route) {
            if ($route['routeName'] == $name) {
                return $route['path'];
            }
        }

        return 'RouteNameNotFound';
    }
    /**
     * Lists all registered routes for debugging purposes.
     */
    public static function list(): void
    {
        $routes = self::$router->routes;
        echo '<pre>';
        var_dump($routes);
        exit();
    }
}
