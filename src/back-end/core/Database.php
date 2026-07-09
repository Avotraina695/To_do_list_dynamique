<?php

namespace core;
use PDO;
use PDOException;

class Database
{
    private $host = "localhost";
    private $dbname = "todo_app";
    private $user = "root";
    private $password = "1234";

    protected PDO $connection;

    public function __construct(){
        $this->connect();
    }

    public function connect() :PDO{
        if(!isset($this-> connection)){
            try {
                $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }catch (PDOException $e){
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->connection;
    }



}