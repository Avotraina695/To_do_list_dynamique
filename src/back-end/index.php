<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use Controller\Controller;

$controller = new Controller();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if ($method === 'POST' && $uri === '/tasks') {
    $controller->ajout_task();
    exit;
}


if ($method === 'GET' && $uri === '/tasks') {
    $controller->getTasks();
    exit;
}


if ($method === 'PUT' && preg_match('#^/tasks/(\d+)$#', $uri, $matches)) {
    $id = (int)$matches[1];
    $controller->updateTask($id);
    exit;
}


if ($method === 'DELETE' && preg_match('#^/tasks/(\d+)$#', $uri, $matches)) {
    $id = (int)$matches[1];
    $controller->deleteTask($id);
    exit;
}

http_response_code(404);
header("Content-type: application/json");
echo json_encode([
    "success" => false,
    "message" => "Route non trouvée."
]);