<?php
require '../tfa/ValidationHelper.php';  
require '../tfa/OTPHelper.php';
$message = '';
class Database {
    private $host =  "localhost";
    private $db_name = "iap_d";
    private $username = "root";
    private $password = "Patrickmaina05$";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

class User{
    private $conn;
    private $table_name = "users";

    public $fullname;
    public $username;
    public $email;
    public $password;
    public $genderId;
    public $roleId;
    private $otp;

    public function __construct($db){
        $this->conn = $db;
    }

    public function validateInput(){
        if(!preg_match("/^[a-zA-Z\s'-]+$/", $this->fullname)){
            return "Your name can only contain letters, spaces, dashes, and question marks";
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            return "Invalid email format";
        }
        
        $allowed_domains = ['strathmore.edu', 'gmail.com', 'yahoo.com', 'mada.co.ke'];
        $email_domain = substr(strrchr($this->email, "@"), 1);

        if(!in_array($email_domain, $allowed_domains)){
            return "Email domain '$email_domain' is not allowed";
        }

        if(!in_array($email_domain, $allowed_domains)){
            return "Email domain '$email_domain' is not authorized";
        }

        $disallowed_usernames = ['admin', 'root', 'superuser'];
        if(in_array(strtolower($this->username), $disallowed_usernames)){
            return "this username'" . $this->username . "' is not allowed";
        }

        if($this->emailExists()){
            return "Email already exists";
        }
         if($this->usernameExists()){
            return "Username already exists";
         }

         return null;
    }

    private function emailExists(){
        $query = "SELECT email FROM " . $this->table_name . "WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->rowCount() > 0;
    }

    private function usernameExists(){
        $query = "SELECT username FROM " . $this->table_name . " Where username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }


    public function createUser($repeatPassword){
        $validationError = ValidationHelper::validate($this->fullname, $this->username, $this->email, $this->password, $repeatPassword, $this->conn);
        if ($validationError) {
            return $validationError;
        }
    
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); 
        $this->genderId = htmlspecialchars(strip_tags($this->genderId));
        $this->roleId = htmlspecialchars(strip_tags($this->roleId));
        $this->otp = OTPHelper::generateOTP(); // Generate OTP
    
        $query = "INSERT INTO " . $this->table_name . " (fullname, username, email, password, genderId, roleId, otp) 
                  VALUES (:fullname, :username, :email, :password, :genderId, :roleId, :otp)";
        
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":genderId", $this->genderId);
        $stmt->bindParam(":roleId", $this->roleId);
        $stmt->bindParam(":otp", $this->otp);  // Ensure OTP is bound
    
        if($stmt->execute()) {
            OTPHelper::sendOTP($this->email, $this->otp);
            return "User created successfully";
        }
        return "Failed to create user. Please try again.";
    }
    
    
}

if($_POST) {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->fullname = $_POST['fullname'];
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->genderId = $_POST['genderId'];
    $user->roleId = $_POST['roleId'];

    $repeatPassword = $_POST['repeat_password'];

    $result = $user->createUser($repeatPassword);
    echo "<div class='alert alert-info'>$result</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&family=Roboto+Mono&display=swap" rel="stylesheet">
    <style>
        body{
            background-color: #1e1e1e;
            color: #f5f5f5;
            font-family: 'Raleway', sans-serif;
        }
        h2 {
            font-family: 'Roboto Mono', monospace;
            font-weight: 300;
            letter-spacing: 0.1em;
        }

        .form-container {
            background-color: #2e2e2e;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s ease-in-out;
        }
        .form-container:hover {
            transform: translateY(-10px);
        }
        .btn-custom {
            background-color: #f39c12;
            color: #fff;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #e67e22;
        }
        input, select {
            background-color: #444;
            color: #fff;
            border: none;
        }
        input:focus, select:focus {
            background-color: #555;
            color: #fff;
            border: none;
        }
        ::placeholder {
            color: #888;
        }
        .alert {
            border-radius: 0;
            text-align: center;
            font-size: 1.1rem;
        }

    </style>

</head>
<body>
<div class="container mt-5">
        <h2 class="text-center mb-4">Sign Up</h2>
        <div class="form-container mx-auto col-md-6">
            <form method="POST" action="signup.php">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" name="fullname" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="repeat_password">Repeat Password</label>
                    <input type="password" name="repeat_password" class="form-control" placeholder="Repeat your password" required>
                </div>
                <div class="form-group">
                    <label for="genderId">Gender</label>
                    <select name="genderId" class="form-control" required>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="roleId">Role</label>
                    <select name="roleId" class="form-control" required>
                        <option value="1">Admin</option>
                        <option value="2">User</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom btn-block">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>