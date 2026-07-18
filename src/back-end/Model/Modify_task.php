<?php

namespace Model;

use core\Database;
use http\Encoding\Stream;
use PDO;

class Modify_task extends Database
{
    public function modifyTask(int $id ,string $title)
    {
        $check = $this->connection->prepare("SELECT * FROM tasks WHERE id = :id");
        $check->bindParam(':id', $id , PDO::PARAM_INT);
        $check->execute();
        if (!$check->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        $sql = "UPDATE tasks SET title = :title WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $select = $this-> connection-> prepare("SELECT * FROM tasks WHERE id = :id");
        $select->bindParam(':id', $id, PDO::PARAM_INT);
        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }
}