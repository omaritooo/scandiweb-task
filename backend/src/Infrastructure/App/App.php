<?php

namespace Infrastructure\App;

use Infrastructure\Config\Config;
use Infrastructure\Container\Container;
use Infrastructure\Database\DB;
use Infrastructure\Router\Router;


class App
{
    private static DB $db;
    protected Container $container;
    protected Router $router;
    protected array $request;
    protected Config $config;

    public function __construct(
        Container $container,
        Router    $router,
        array     $request,
        Config    $config
    )
    {
        $this->config = $config;
        $this->request = $request;
        $this->router = $router;
        $this->container = $container;
        static::$db = new DB($config->db ?? []);
    }

    public static function build(Container $container, Router $router, array $request, Config $config): App
    {
        return new static($container, $router, $request, $config);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (\Exception $e) {
            http_response_code(404);
        }
    }
}