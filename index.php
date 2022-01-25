<?php

use Controllers\ProductsController;

require_once "./vendor/autoload.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$method = $uri[2] ?? null;
$id = $uri[3] ?? null;

if (isset($_REQUEST["page"])) {
    $page = $_REQUEST["page"] - 1;
    unset($_REQUEST["page"]);
} else {
    $page = '0';
}

if (isset($_REQUEST["orderby"])) {
    $orderBy = $_REQUEST["orderby"];
    unset($_REQUEST["orderby"]);
} else {
    $orderBy = 'id';
}

if (isset($_REQUEST["ordertype"])) {
    $orderType = $_REQUEST["ordertype"];
    unset($_REQUEST["ordertype"]);
} else {
    $orderType = 'ASC';
}

$filters = $_REQUEST;
array_shift($filters);

$controller = new ProductsController();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if ($id != null) {
    $data = $controller->getProduct($id);
    echo json_encode($data);
} elseif ($filters != null) {
    $data = $controller->search($filters, $page, $orderBy, $orderType);
    echo json_encode($data);
} elseif ($id == null) {
    $data = $controller->getProducts($page, $orderBy, $orderType);
    echo json_encode($data);
} else {
    http_response_code(404);
    echo 404;
}