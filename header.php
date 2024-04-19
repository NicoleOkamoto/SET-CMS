<?php


session_set_cookie_params(1080); // 30 minutes in seconds
session_start();

// Check if the user is verified
$verified_user = isset($_SESSION['is_verified']) && $_SESSION['is_verified'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Authentication successful
        $_SESSION['is_verified'] = true; // Set user as verified
        $_SESSION['first_name'] = $user['first_name']; // Store the user's first name
        header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to the same page
        exit;
    } else {
        // Authentication failed
        echo "Invalid username or password. header";
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
    <div class="bg-light py-2 d-flex flex-column pr-9">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <img src="images/SET-BOOKS.png" alt="Logo" height="90px">
        </a>
        <!-- Login form always displayed on the right -->
        <form class="row g-3 ms-auto ml-5 mr-5 mt-0 mb-0 pr-10" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="col-auto">
                <label for="username" class="visually-hidden">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="col-auto">
                <label for="password" class="visually-hidden">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mr-3">Login</button>
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

<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light mt-3">    
    <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">🔹Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">🔹About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blog.php">🔹Info Hub</a>
            </li>
        </ul>
    </div>
</div>
</nav>

<!-- Bootstrap JavaScript and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
