<?php

define('BASE_PATH', __DIR__ . "/../");

require_once BASE_PATH . "vendor/autoload.php";
require_once BASE_PATH . "app/core/helpers.php";


$router = App\Core\Router::getRouter();
$app = new App\Core\App();

require BASE_PATH . "routes.php";

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

try {
    $router->route($method, $uri);
}catch (\Throwable $e) {
    echo $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine();
} finally {
    exit();
}
