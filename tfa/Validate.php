<?php
class ValidationHelper {
    public static function validate($fullname, $username, $email, $password, $repeatPassword, $conn) {
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

        if (self::emailExists($email, $conn)) {
            return "Email already exists";
        }
        if (self::usernameExists($username, $conn)) {
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

    private static function emailExists($email, $conn) {
        $query = "SELECT email FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    private static function usernameExists($username, $conn) {
        $query = "SELECT username FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>
