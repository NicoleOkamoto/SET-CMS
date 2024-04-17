<?php
require('connect.php');

// Fires off a session cookie
session_start();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>

<?php
// Display the welcome message if the user is verified
if ($verified_user) {
    $first_name = $_SESSION['first_name'];
    echo "<p>Welcome, $first_name!</p>";
}
?>

<li><a href="adminlogin.php">Admin Login</a></li>   
<li><a href="create.php">New Post</a></li>
<li><a href="blog.php">Blog</a></li>   

<div class="container">
    <h2>Login</h2>
    <form method="post" action="index.php">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>

