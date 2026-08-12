<?php

namespace Controller;

use Model\Add_task;
use Model\Delete_task;
use Model\List_task;
use Model\Modify_task;
use Model\Update_filtre;

class Controller
{
    private Add_task $add_task;
    private List_task $list_task;
    private Update_filtre $update_task;
    private Delete_task $delete_task;
    private Modify_task $modify_task;



    public function __construct()
    {
        $this->add_task = new Add_task();
        $this->list_task = new List_task();
        $this->update_task = new Update_filtre();
        $this->delete_task = new Delete_task();
        $this->modify_task = new Modify_task();
    }

    public function ajout_task()
    {
        header("Content-type: application/json");
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Invalid request"
            ]);
            return;
        }

        $title = trim($data['title'] ?? "");
        $status = trim($data['status'] ?? "");

        if (empty($title) || empty($status)) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Tous les champs sont obligatoires."
            ]);
            return;
        }

        try {
            $result = $this->add_task->addTask($title, $status);
            http_response_code(201);
            echo json_encode([
                "success" => true,
                "message" => "Tâche ajoutée avec succès.",
                "task" => $result
            ]);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
                // "debug" => $e->getMessage()
            ]);
        }
    }

    public function getTasks()
    {
        header("Content-type: application/json");
        try {
            $task = $this->list_task->getAllTasks();
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "tasks" => $task
            ]);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Erreur serveur lors de la récupération des tâches."
            ]);
        }

    }

    public function updateTask($id){
        header("Content-type: application/json");
        $data = json_decode(file_get_contents("php://input"), true);
        $status = trim($data['status'] ?? "");
        if (empty($status)) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Le champ status est obligatoire."
            ]);
            return;
        }
        try {
            $result = $this->update_task->updateStatus($id, $status);
            if ($result == null){
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Tâche introuvable."
                ]);
                return;
            }
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "task" => $result
            ]);

        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
            ]);
        }
    }

    public function deleteTask($id){
        header("Content-type: application/json");
        try {
            $delete = $this->delete_task-> deleteTask($id);
            if (!$delete) {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Tâche introuvable."
                ]);
                return;
            }
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message " => "Tâche supprimée avec succès."
            ]);

        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Erreur serveur lors de la suppression."
            ]);
        }
    }

    public function ModifyTask($id)
    {
        header("Content-type: application/json");
        $data = json_decode(file_get_contents("php://input"), true);
        $title = trim($data['title'] ?? "");
        if (empty($title)) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => "Tous les champs sont obligatoires."
            ]);
            return;
        }
        try {
            $result = $this->modify_task->modifyTask($id, $title);
            if ($result == null){
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "task" => $result
                ]);
            return;
            }
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "task" => $result
            ]);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
    public function getHistory()
    {
        header("Content-type: application/json");

        try {
            $tasks = $this->list_task->getHistory();

            http_response_code(200);
            echo json_encode([
                "success" => true,
                "tasks" => $tasks
            ]);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Erreur serveur lors de la récupération de l'historique."
            ]);
        }
    }

}