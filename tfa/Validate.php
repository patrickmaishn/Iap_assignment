<?php
class Validate {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public static function validate($fullname, $username, $email, $password, $repeatPassword, $conn) {
        // Create an instance of Validate to use non-static methods
        $validator = new self($conn);
        
        if (!preg_match("/^[a-zA-Z\s'-]+$/", $fullname)) {
            return "Your name can only contain letters, spaces, dashes, and question marks";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format";
        }

        $allowed_domains = ['strathmore.edu', 'gmail.com', 'yahoo.com', 'mada.co.ke'];
        $email_domain = substr(strrchr($email, "@"), 1);

        if (!in_array($email_domain, $allowed_domains)) {
            return "Email domain '$email_domain' is not allowed";
        }

        $disallowed_usernames = ['admin', 'root', 'superuser'];
        if (in_array(strtolower($username), $disallowed_usernames)) {
            return "The username '" . $username . "' is not allowed";
        }

        if ($validator->emailExists($email)) {
            return "Email already exists";
        }

        if ($validator->usernameExists($username)) {
            return "Username already exists";
        }

        if (strlen($password) < 4 || strlen($password) > 8) {
            return "Password must be between 4 and 8 characters";
        }

        if ($password !== $repeatPassword) {
            return "Passwords do not match";
        }

        return null;
    }

    private function emailExists($email) {
        $query = "SELECT email FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    private function usernameExists($username) {
        $query = "SELECT username FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
/*
// Usage example in signup.php
$conn = Validate::createConnection();
$validator = new Validate($conn);

$validation_result = Validate::validate($fullname, $username, $email, $password, $repeatPassword, $conn);
if ($validation_result !== null) {
    echo $validation_result;
} else {
    // Proceed with user registration
}*/
?>
