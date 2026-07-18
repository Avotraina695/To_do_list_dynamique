<?php
namespace Model;

use core\Database;
use PDO;

class Update_filtre extends Database
{
    public function updateStatus(int $id, string $status)
    {
        $check = $this->connection->prepare("SELECT * FROM tasks WHERE id = :id");
        $check->bindParam(':id', $id, PDO::PARAM_INT);
        $check->execute();

        if (!$check->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        $sql = "UPDATE tasks SET status = :status WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $select = $this->connection->prepare("SELECT * FROM tasks WHERE id = :id");
        $select->bindParam(':id', $id, PDO::PARAM_INT);
        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }
}