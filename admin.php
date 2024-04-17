<?php
require('connect.php');
require('authenticate.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $businessName = filter_input(INPUT_POST, 'business_name', FILTER_SANITIZE_STRING);

    // Insert the new user into the database
    $stmt = $pdo->prepare('INSERT INTO users (username, password, email, first_name, last_name, business_name) VALUES (:username, :password, :email, :first_name, :last_name, :business_name)');
    $stmt->execute(['username' => $username, 'password' => $password, 'email' => $email, 'first_name' => $firstName, 'last_name' => $lastName, 'business_name' => $businessName]);

    echo "User created successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
</head>
<body>
    <h1>Admin Portal</h1>
    <h2>Create New User</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required><br><br>
        
        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br><br>
        
        <label for="business_name">Business Name:</label><br>
        <input type="text" id="business_name" name="business_name" required><br><br>
        
        <button type="submit">Create User</button>
    </form>
</body>
</html>
