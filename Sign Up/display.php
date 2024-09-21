<?php

use Database as GlobalDatabase;

class database {
    private $host = "localhost";
    private $db_name = "iap_d";
    private $username = "root";
    private $password = "Patrickmaina05$";
    public $conn;

    public function getConnection(){
       $this->conn = null;
       try {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       }catch(PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
           }
           return $this->conn;
    }
}

class User{
    private $conn;
    private $table_name = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUsers(){
        $query = "SELECT *FROM " .$this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

$database = new database();
$db = $database->getConnection();
$user = new User($db);
$users = $user->getUsers();
?>

