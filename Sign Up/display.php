<?php
class Database {
    private $host = "localhost:3307";
    private $db_name = "iap_d";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUsers(){
        $query = "SELECT * FROM " .$this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$users = $user->getUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&family=Roboto+Mono&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #1e1e1e;
            color: #f5f5f5;
            font-family: 'Raleway', sans-serif;
        }
        h2 {
            font-family: 'Roboto Mono', monospace;
            font-weight: 300;
            letter-spacing: 0.1em;
        }
        .table-container {
            background-color: #2e2e2e;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s ease-in-out;
        }
        .table-container:hover {
            transform: translateY(-10px);
        }
        table {
            color: #fff;
        }
        th {
            background-color: #333;
        }
        td {
            background-color: #444;
        }
        td, th {
            padding: 1rem;
        }
        tr:hover td {
            background-color: #555;
        }
    </style>

</head>
<body>
<div class="container mt-5">
        <h2 class="text-center">Users List</h2>
        <div class="table-container mx-auto col-md-10">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Role ID</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['userId']); ?></td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['genderId']); ?></td>
                        <td><?php echo htmlspecialchars($row['roleId']); ?></td>
                        <td><?php echo htmlspecialchars($row['created']); ?></td>
                    </tr>
                <?php endwhile;?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
