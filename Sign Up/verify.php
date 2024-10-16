<?php
require 'signup.php';

if($_POST) {
    $database = new Database();
    $db = $database->getConnection();

    $email = $_GET['email'];
    $otp = $_POST['otp'];

    $query = "SELECT otp FROM users WHERE email = :email AND verified = FALSE";
    $stmt = $db->prepare($query);
    $stmt->bindparam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result && $result['otp'] == $otp){
        $updateQuery = "UPDATE users SET verified = TRUE WHERE email = :email";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bindParam(":email", $email);
        $updateStmt->execute();

        echo "<div class= 'alert alert-accesss'> Registration varified Successfully! </div>";
    }else{
        echo "<div class= 'alert alert-accesss'>Invalid OTP. Try again. </div>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background-color: lightslategray;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Verify OTP</h2>
    <div class="form-container mx-auto col-md-6">
        <form method="POST" action="verify.php?email=<?php echo urlencode($_GET['email']); ?>">
            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="text" name="otp" class="form-control" placeholder="Enter the OTP" required>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Verify</button>
        </form>
    </div>
</div>
</body>
</html>