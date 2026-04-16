<?php

header('Content-Type: application/json');

require 'config.php';

if (!isset($pdo)) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]);
    exit();
}

try {
    $query = "SELECT * FROM tasks ORDER BY created_at DESC";
    $stmt = $pdo->query($query);

    $tasks = $stmt->fetchAll();

    echo json_encode([
        "status" => "success",
        "tasks" => $tasks,
        "message" => "Tasks retrieved successfully."
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "DATABASE ERROR: " . $e->getMessage()
    ]);
}