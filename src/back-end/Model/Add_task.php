<?php
namespace Model;

use core\Database;
use PDO;

class Add_task extends Database
{
    public function addTask($title, $status)
    {
        $sql = "INSERT INTO tasks (title, status) VALUES (:title, :status)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        $id = $this->connection->lastInsertId();

        $select = $this->connection->prepare("SELECT * FROM tasks WHERE id = :id");
        $select->bindParam(':id', $id);
        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }
}