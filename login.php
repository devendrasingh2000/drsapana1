<?php
session_start();
include('config.php');

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple input validation
    if(empty($username) || empty($password)) {
        echo '<div class="error-message">Please fill in all fields.</div>';
    } else {
        // Sanitize inputs if needed (though prepared statements are better for security)
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        // Query to fetch user
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
        $query = mysqli_query($conn, $sql);
        if($query) {
            if(mysqli_num_rows($query) == 1) {
                $user = mysqli_fetch_assoc($query);
                    $_SESSION['username'] = $username;
                    header('Location: ./admin/index.php');
                    exit;
            } else {
                echo '<div class="error-message">Username not found.</div>';
            }
        } else {
            echo '<div class="error-message">Error executing query: ' . mysqli_error($conn) . '</div>';
        }
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login-form" id="loginForm">
        <h2>Login</h2>
        <div class="input-group">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <div class="error-message" id="username-error"><?php if (isset($error_message)) { echo $error_message; } ?></div>
        </div>
        <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="error-message" id="password-error"></div>
        </div>
        <button type="submit" name="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register here</a></p> <!-- Registration link -->
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/script.js"></script> <!-- You can add client-side validation script if needed -->
</body>
</html>
