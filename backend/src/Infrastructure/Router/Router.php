<?php

declare(strict_types=1);

namespace Infrastructure\Router;

use App\Exceptions\ContainerException;
use App\Exceptions\NotFoundException;
use App\Exceptions\RouteNotFoundException;
use Infrastructure\Container\Container;

class Router
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function register(string $requestMethod, string $route,  $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route,  $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route,  $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * @throws RouteNotFoundException
     * @throws NotFoundException
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (! $action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = $this->container->get($class);

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }

}