<?php
require_once 'config.php';
global $pdo;
header("content-type:application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($pdo)){
    echo json_encode([
        "status" => "error",
        "message" => "Task not created!"
    ]);
    exit();
}


if (!isset($data['id']) && !isset($data['status'])) {
    echo json_encode([
        "status" => "Error",
        "message" => "Aucune donnee"
    ]);
    exit();
}

try {
    $query = "UPDATE tasks SET status = ? WHERE id = ? ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$data['status'], $data['id']]);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "Error",
        "message" => "Task not created!"
    ]);
}
