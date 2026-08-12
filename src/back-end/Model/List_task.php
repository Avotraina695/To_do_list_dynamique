<?php

namespace Model;

use core\Database;
use PDO;

class List_task extends Database
{

    public function getAllTasks(): array
    {
        $sql = "SELECT * FROM tasks WHERE deleted_at IS NULL ORDER BY created_at DESC";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getHistory(): array
    {
        $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}