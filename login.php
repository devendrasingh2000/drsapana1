<?php
session_start();
include('config.php');

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform any necessary input validation or sanitization here

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    if ($result) {
        // Verify password - Example using password_verify (assuming passwords are hashed)
            $_SESSION['username'] = $username;
            header('Location: ./admin/index.php');
            exit;
    } else {
        // Username not found
        echo "Username not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<link rel="stylesheet" href="assets/css/styles.css">
<style>
    .error-message {
        color: red;
        font-size: 0.8em;
        margin-top: 5px;
    }
</style>
</head>
<body>
<div class="login-container">
    <form action="" method="POST" class="login-form" id="loginForm">
        <h2>Login</h2>
        <div class="input-group">
            <input type="text" id="username" name="username" placeholder="Username">
            <div class="error-message" id="username-error"></div>
        </div>
        <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Password">
            <div class="error-message" id="password-error"></div>
        </div>
        <button type="submit" name="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register here</a></p> <!-- Registration link -->
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
