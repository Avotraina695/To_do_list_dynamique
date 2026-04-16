<?php
$host = "localhost";
$dbname = "todo_app";
$user = "root";
$password = "1234";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8" , $user, $password);
    $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo-> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}