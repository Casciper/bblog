<?php

if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use App\Core\Router;
use App\Core\View;
use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\ArticleController;

$router = new Router();
$view   = new View();

$router->get('/', function () use ($view) {
    (new HomeController($view))->index();
});

$router->get('/category/{id}', function (string $id) use ($view) {
    (new CategoryController($view))->show($id, 1);
});

$router->get('/category/{id}/p{page}', function (string $id, string $page) use ($view) {
    (new CategoryController($view))->show($id, (int) $page);
});

$router->get('/article/{id}', function (string $id) use ($view) {
    (new ArticleController($view))->show($id);
});

$router->dispatch($_SERVER['REQUEST_URI']);
