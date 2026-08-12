<?php

namespace Model;

use core\Database;
use PDO;

class Delete_task extends Database
{
    public function deleteTask(int $id): bool
    {
        $sql = "UPDATE tasks SET deleted_at = NOW() WHERE id = :id AND deleted_at IS NULL";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}