<?php

session_set_cookie_params(5); // 30 minutes in seconds

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Your Website</title>

</head>
<body>


<div class="container">

 <!-- Logo -->
 <div class="logo">
        <img src="images/SET-BOOKS.png" alt="Logo">
    </div>


    <div class="bg-light py-2 d-flex flex-column align-items-end">
        <!-- Login form always displayed on the right -->
        <form class="row g-3 ms-auto" method="post" action="index.php">
            <div class="col-auto">
                <label for="username" class="visually-hidden">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="col-auto">
                <label for="password" class="visually-hidden">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Login</button>
                <?php if ($verified_user): ?>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                <?php endif; ?>
            </div>
        </form>
        
        <!-- Welcome message displayed on the next line, aligned -->
        <?php if ($verified_user): ?>
            <div class="text-end">
                <?php
                    $first_name = $_SESSION['first_name'];
                    echo "<p class='m-0'>Welcome, $first_name!</p>";
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>

   

    <!-- Main image with contact form -->
    <div class="container mt-3">
    <div class="image-wrapper">
        <img src="images/towfiqu-barbhuiya-JhevWHCbVyw-unsplash.jpg" class="img-fluid" alt="">
        <div class="overlay">
            <div class="form-container">
                <!-- Add your form here -->
                <h2>Free Consultation Form</h2>
                <form action="#" method="post">
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name"><br>
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email"><br><br>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>



    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Your Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    
    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



 <!-- Social media links -->
 <div>
            <img src="./images/whatsapp.svg" alt="WhatsApp logo">
            <img src="./images/linkedin.svg" alt="LinkedIn logo">
            <img src="./images/facebook.svg" alt="Facebook logo">
            <img src="./images/instagram.svg" alt="Instagram logo">
        </div>
