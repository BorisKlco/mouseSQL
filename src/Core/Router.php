<?php

namespace Core;

use Middleware\Middlewares;

class Router
{
    public array $routes;

    public function register(string $method, string $route, callable|array $action): self
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $route,
            'action' => $action,
            'middleware' => null,
            'routeName' => ''
        ];
        return $this;
    }
    /**
     * Assigns a middleware to the last registered route.
     *
     * @param string $middleware The name of the middleware to be applied.
     * @return self Returns the Router instance for method chaining.
     */
    public function only(string $middleware): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
        return $this;
    }
    /**
     * Assigns a name to the last registered route.
     *
     * @param string $routeName The name of the route.
     * @return self Returns the Router instance for method chaining.
     */
    public function name(string $routeName): self
    {
        $this->routes[array_key_last($this->routes)]['routeName'] = $routeName;
        return $this;
    }

    public function resolve(string $uri, string $method): void
    {
        $path = parse_url($uri)['path'];
        $action = null;
        $middleware = null;

        foreach ($this->routes as $route) {
            if ($route['method'] == $method && $route['path'] == $path) {
                $action = $route['action'];
                $middleware = $route['middleware'];
            }
        }

        if (!$action) {
            View::NotFound();
        }

        if ($middleware) {
            $class = Middlewares::MAP[$middleware] ?? null;
            if ($class) {
                (new $class)->handle();
            } else {
                View::NotFound("Middleware '{$middleware}' is missing.");
            }
        }

        if (is_callable($action)) {
            call_user_func($action);
            exit();
        }

        [$class, $fn] = $action;
        if (class_exists($class) && method_exists($class, $fn)) {
            $controller = new $class();
            call_user_func([$controller, $fn]);
            exit();
        }
        View::NotFound("Controller '{$class}' or method '{$fn}' is missing.");
    }
}
