<?php

require('connect.php');
// Start the session
session_start();

// Check if the user is logged in
$logged_in = isset($_SESSION['user_id']);

// If user is not logged in, redirect to homepage
if (!$logged_in) {
    header('Location: index.php');
    exit;
}

// Logged-in user page content
echo "Welcome, logged-in user!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged User Page</title>
</head>
<body>
    <h1>Welcome, logged-in user!</h1>
    <p>This is the special content for logged-in users.</p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
