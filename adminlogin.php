<?php

require ('connect.php');

define('ADMIN_LOGIN','wally');
define('ADMIN_PASSWORD','mypass');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if ($username == ADMIN_LOGIN && $password == ADMIN_PASSWORD) {
        // Authentication successful
        header('Location: admin.php');
        exit; // Make sure to exit after redirecting
    } else {
        // Authentication failed
        echo "Invalid username or password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
