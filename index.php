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
        // // Debugging output
        // echo "<pre>";
        // echo "Username from form: $username\n";
        // echo "Password from form: $password\n";
        // echo "Hashed password from DB: " . $user['password'] . "\n";
        // echo "</pre>";
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <div class="container mt-3">
        <!-- Image with contact form -->
        <div class="image-wrapper">
            <img src="images/towfiqu-barbhuiya-JhevWHCbVyw-unsplash.jpg" class="img-fluid" alt="">
            <div class="overlay">
                <div class="form-container">
                    <!-- Captcha form -->
                    <script src="https://web3forms.com/client/script.js" async defer></script>
                    <form class="form-container" id="myForm" action="https://api.web3forms.com/submit" method="POST">
                        <input type="hidden" name="access_key" value="e5cbb0ea-9a92-40d9-b437-7e92202582e4">
                        <label class="form-title">Book a Free Consultation!</label>
                        <input class="form-control mb-3" type="text" name="name" placeholder="Name" required>
                        <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
                        <textarea class="form-control mb-3" name="message" rows="3" placeholder="Tell us about your needs!" required></textarea>
                        <div class="h-captcha" data-captcha="true"></div>
                        <button class="btn btn-primary" type="submit">Submit Form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


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

<?php require ('footer.php'); ?>
<script src="script.js"></script>

</html>