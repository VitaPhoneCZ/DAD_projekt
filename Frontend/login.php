<?php
// Start the session to store user information
session_start();

// Redirect to dashboard if the user is already logged in
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Include the login process script to handle the form submission
include 'login_process.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        
        <!-- Display error message if login fails -->
        <?php if (isset($error_message)): ?>
            <p class="error"><?= $error_message; ?></p>
        <?php endif; ?>
        
        <!-- Login form -->
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            
            <button type="submit">Login</button>
        </form>
        
        <p>Zapoměli jste heslo? <a href="forgot_password.php">Nové heslo</a></p>
    </div>
</body>
</html>
