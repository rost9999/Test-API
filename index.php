<?php

use Controllers\ProductsController;

require_once "./vendor/autoload.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$method = $uri[2] ?? null;
$id = $uri[3] ?? null;
$filters = $_REQUEST["filter"] ?? null;

$page = $_REQUEST["page"] ?? 1;
$orderBy = $_REQUEST["orderby"] ?? 'id';
$orderType = $_REQUEST["ordertype"] ?? 'ASC';

$controller = new ProductsController();

if ($id) {
    $data = $controller->getProduct($id);
} elseif ($filters != null) {
    $data = $controller->search($filters, $page, $orderBy, $orderType);
} elseif ($id == null) {
    $data = $controller->getProducts($page, $orderBy, $orderType);
} else {
    http_response_code(404);
    die();
}
echo json_encode($data);