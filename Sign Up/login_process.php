<?php
session_start();


require '../includes/dbconnection.php';


$db_type = 'PDO';
$db_host = 'localhost';
$db_port = '3307'; 
$db_user = 'root'; 
$db_pass = ''; 
$db_name = 'iap_d'; 


$dbObj = new dbConnection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name);
$db = $dbObj->getConnection(); 


if (!($db instanceof PDO)) {
    die("Error: Database connection not established.");
}


if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if (password_verify($password, $user['password'])) { 
            $_SESSION['username'] = $username; 
            header("Location: ../index.php"); 
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>
