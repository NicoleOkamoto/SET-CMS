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
    if ($stmt->execute(['username' => $username, 'password' => $password, 'email' => $email, 'first_name' => $firstName, 'last_name' => $lastName, 'business_name' => $businessName])) {
        echo "User created successfully.";
    } else {
        echo "Error creating user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Admin Portal</title>
</head>
<body>
    <h1>Admin Portal</h1>
    <div class="container">
    <h2>Create New User</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username" class="form-label">Username:</label><br>
        <input type="text" class="form-control" id="username" name="username" required><br><br>
        <label for="password" class="form-label">Password:</label><br>
        <input type="password"  class="form-control" id="password" name="password" required><br><br>
        
        <label for="email" class="form-label">Email:</label><br>
        <input type="email" class="form-control" id="email" name="email" required><br><br>
        
        <label for="first_name" class="form-label">First Name:</label><br>
        <input type="text" class="form-control" id="first_name" name="first_name" required><br><br>
        
        <label for="last_name" class="form-label">Last Name:</label><br>
        <input type="text" class="form-control" id="last_name" name="last_name" required><br><br>
        
        <label for="business_name" class="form-label">Business Name:</label><br>
        <input type="text"  class="form-control" id="business_name" name="business_name" required><br><br>
        
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
</div>

</form>
<h2>Edit Blog</h2>
<li><a href="createBlogPost.php">New Post</a></li>
</div>
</body>
</html>
