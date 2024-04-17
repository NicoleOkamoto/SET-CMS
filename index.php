<?php
require('connect.php');
require ('header.php');
// Fires off a session cookie


$verified_user = isset($_SESSION['is_verified']) && $_SESSION['is_verified'];



// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize username
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // Hash and salt password
    $password = $_POST['password'];

    // Check username and password against database
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Authentication successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_verified'] = true; // Set user as verified
        $_SESSION['first_name'] = $user['first_name']; // Store the user's first name
        header('Location: index.php'); // Redirect to dashboard after successful login
        exit;
    } else {
        // Authentication failed
        echo "Invalid username or password.";
        // Debugging output
        echo "<pre>";
        echo "Username from form: $username\n";
        echo "Password from form: $password\n";
        echo "Hashed password from DB: " . $user['password'] . "\n";
        echo "</pre>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Your Website</title>
   
</head>
<body>


    <!-- Grid with 4 elements -->
    <div class="container mt-3">
        <div class="row">
            <!-- First grid element -->
            <div class="col-md-3">
                <!-- Image and short text -->
            </div>
            <!-- Repeat for the other grid elements -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-3 text-center">
        <div class="container">
            <!-- Footer content here -->
            <a href="admin.php" class="text-light" style="text-decoration: none;">Admin Login</a>
            <li><a href="admin.php">Admin Login</a></li>   
        </div>
    </footer>


