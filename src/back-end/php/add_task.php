<?php

require 'config.php'; // important
header('Content-Type: application/json');

global $pdo;

$tasks = json_decode(file_get_contents('php://input') , true);

if (!is_array($tasks) || !$tasks) {
    echo json_encode([
        "status" => "error",
        "message" => "Tasks data is invalid."
    ]);
    exit;
}

try {
    $query = "INSERT INTO tasks (title, status) VALUES (:title, :status)";
    $stmt = $pdo->prepare($query);

    foreach ($tasks as $task) {
        $title = trim($task);
        $status = "Pending";
        if ($title !== ""){
            $stmt->execute([
                ":title" => $title,
                ":status" => $status
            ]);
        }
    }
    echo json_encode([

        "status" => "success",
        "message" => "Task added successfully.".$task
    ]);

}catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}