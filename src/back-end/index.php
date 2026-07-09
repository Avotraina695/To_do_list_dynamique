<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use Controller\Controller;

$controller = new Controller();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// POST /tasks
if ($method === 'POST' && $uri === '/tasks') {
    $controller->ajout_task();
    exit;
}

// GET /tasks
if ($method === 'GET' && $uri === '/tasks') {
    $controller->getTasks();
    exit;
}

// PUT /tasks/{id}
if ($method === 'PUT' && preg_match('#^/tasks/(\d+)$#', $uri, $matches)) {
    $id = (int) $matches[1];
    $controller->updateTask($id);
    exit;
}

// DELETE /tasks/{id}
if ($method === 'DELETE' && preg_match('#^/tasks/(\d+)$#', $uri, $matches)) {
    $id = (int) $matches[1];
    $controller->deleteTask($id);
    exit;
}

http_response_code(404);
header("Content-type: application/json");
echo json_encode([
    "success" => false,
    "message" => "Route non trouvée."
]);