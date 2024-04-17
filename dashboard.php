<?php
// dashboard.php

require ('connect.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    // Unset the session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <h2>Welcome to the Dashboard</h2>
        <p>This is a protected area. Only logged-in users can access this page.</p>
        <form method="post">
            <input type="hidden" name="logout" value="true">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</body>
</html>