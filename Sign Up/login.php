<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #333; 
            color: #fff; 
        }
        .form-container {
            background-color: #444; 
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .btn-custom {
            background-color: #555; 
            color: #fff; 
        }
        .btn-custom:hover {
            background-color: #666; 
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Login</h2>
    <div class="form-container mx-auto col-md-6">
        <form method="POST" action="login_process.php"> 
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Login</button>
        </form>
    </div>
</div>
</body>
</html>