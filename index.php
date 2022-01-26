<?php

use Controllers\ProductsController;

require_once "./vendor/autoload.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$uri        = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri        = explode('/', $uri);
$method     = $uri[2] ?? null;
$productID  = $uri[3] ?? null;
$filters    = $_REQUEST["filter"] ?? null;
$pageID     = $_REQUEST["page"] ?? 1;
$orderBy    = $_REQUEST["orderby"] ?? 'id';
$orderType  = $_REQUEST["ordertype"] ?? 'ASC';

$controller = new ProductsController();

$data   = [];

if ($productID) {
    $data = $controller->getProduct($productID);
} elseif ($filters) {
    $data = $controller->search($filters, $pageID, $orderBy, $orderType);
} else {
    $data = $controller->getProducts($pageID, $orderBy, $orderType);
}

if (count($data) == 0) {
    http_response_code(404);
    $data = ['message' => 'Product Not Found'];
}
echo json_encode($data);
