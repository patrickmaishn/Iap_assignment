<?php
class database{
    private $host = "localhost";
    private $db_name = "iap_d";
    private $username = "root";
    private $password = "Patrickmaina05$";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception){
            echo "connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

class user{
    private $conn;
    private $table_name = "users";

    public $fullname;
    public $username;
    public $email;
    public $password;
    public $genderId;
    public $roleId;

    public function __construct($db){
        $this->conn = $db;
    }
    public function createUser(){
        $query = "INSERT INTO" . $this->table_name . " (fullname, username, email, password, genderId, roleId) VALUES (:fullname, :username, :email, :password, :genderId, :roleId)";
        $stmt = $this->conn->prepare($query);
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); // Hash password for security
        $this->genderId = htmlspecialchars(strip_tags($this->genderId));
        $this->roleId = htmlspecialchars(strip_tags($this->roleId));

        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":genderId", $this->genderId);
        $stmt->bindParam(":roleId", $this->roleId);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

}