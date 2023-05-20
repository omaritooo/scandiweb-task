<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use Dotenv\Dotenv;
use Infrastructure\App\App;
use Infrastructure\Config\Config;
use Infrastructure\Container\Container;
use Infrastructure\Router\Router;

require_once __DIR__ . '/vendor/autoload.php';

Dotenv::createImmutable(__DIR__)->load();


$container = new Container();
$router = new Router($container);


$router->get('/product/get', [ProductController::class, 'index']);
$router->get('/product/saveApi', [ProductController::class, 'store']);
$router->get('/product/delete', [ProductController::class, 'delete']);


App::build(
    $container,
    $router,
    [
        'uri' => $_SERVER['REQUEST_URI'],
        'method' => $_SERVER['REQUEST_METHOD'],
    ],
    new Config($_ENV)
)->run();
