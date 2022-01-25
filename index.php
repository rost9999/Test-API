<?php

use Controllers\ProductsController;

require_once "./vendor/autoload.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$method = $uri[2] ?? null;
$id = $uri[3] ?? null;
$filters = $_REQUEST;
array_shift($filters);

$controller = new ProductsController();
if (empty($method)) {
    $method = 'products';
}

if ($id != null) {
    $data = $controller->$method($id);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($data);
} elseif ($filters != null) {
    $data = $controller->search($filters);
} else {
    http_response_code(404);
    echo 404;
}