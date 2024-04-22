<?php
require('connect.php');
require('authenticate.php');

//CREATE NEW USER SECTION
// Check if the form create user form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
    // Sanitize inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $businessName = filter_input(INPUT_POST, 'business_name', FILTER_SANITIZE_STRING);

    try {
        // Insert the new user into the database
        $stmt = $pdo->prepare('INSERT INTO users (username, password, email, first_name, last_name, business_name) VALUES (:username, :password, :email, :first_name, :last_name, :business_name)');
        $stmt->execute(['username' => $username, 'password' => $password, 'email' => $email, 'first_name' => $firstName, 'last_name' => $lastName, 'business_name' => $businessName]);
        echo "User created successfully.";
    } catch (PDOException $e) {
        // Check if the error is due to a duplicate username
        if ($e->errorInfo[1] == 1062) {

            echo '<script>alert("Username already exists. Please choose a different username.");</script>';
        } else {
            // Output JavaScript alert for other errors
            echo '<script>alert("Error creating user.");</script>';
        }
    }
}

//EDIT BLOG SECTION
// Query to fetch all blog post titles
$query = "SELECT id, title FROM blog";
$statement = $pdo->query($query);
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

//CHANGE HOMEPAGE IMAGE
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_image'])) {
    // Check if a file was selected
    if ($_FILES['header_image']['error'] === UPLOAD_ERR_OK) {
        $tempFile = $_FILES['header_image']['tmp_name'];
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($_FILES['header_image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check file size (limit to 5MB)
        if ($_FILES['header_image']['size'] > 5 * 1024 * 1024) {
            $errorMessage = "Image file is too large. Please upload an image under 5MB.";
            echo "<script>alert('$errorMessage');</script>";
        } // Allow certain file formats
        else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errorMessage = "Only JPG, JPEG, PNG & GIF files are allowed.";
            echo "<script>alert('$errorMessage');</script>";
        } else {
            // Read the file contents
            $imageData = file_get_contents($tempFile);

            // Insert a new row into the settings table
            $query = "INSERT INTO settings (header_image) VALUES (:header_image)";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':header_image', $imageData, PDO::PARAM_LOB);
            if ($statement->execute()) {
                $successMessage = "Header image uploaded successfully.";
                echo "<script>alert('$successMessage');</script>";
                header("Location: index.php");
                exit; // Stop further execution after redirection
            } else {
                $errorMessage = "Error uploading header image.";
                echo "<script>alert('$errorMessage');</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<header>
    <?php require ('adminHeader.php'); ?>
</header>

<body>
    <div class="container">

        <!-- Form to create the new users -->
        <h2>Create New User</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table class="table">
                <tbody>
                    <tr>
                        <td><label for="username" class="form-label">Username:</label></td>
                        <td><input type="text" class="form-control" id="username" name="username" required></td>
                    </tr>
                    <tr>
                        <td><label for="password" class="form-label">Password:</label></td>
                        <td><input type="password" class="form-control" id="password" name="password" required></td>
                    </tr>
                    <tr>
                        <td><label for="email" class="form-label">Email:</label></td>
                        <td><input type="email" class="form-control" id="email" name="email" required></td>
                    </tr>
                    <tr>
                        <td><label for="first_name" class="form-label">First Name:</label></td>
                        <td><input type="text" class="form-control" id="first_name" name="first_name" required></td>
                    </tr>
                    <tr>
                        <td><label for="last_name" class="form-label">Last Name:</label></td>
                        <td><input type="text" class="form-control" id="last_name" name="last_name" required></td>
                    </tr>
                    <tr>
                        <td><label for="business_name" class="form-label">Business Name:</label></td>
                        <td><input type="text" class="form-control" id="business_name" name="business_name" required>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" name="create_user" class="btn btn-primary">Create User</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    </form>

    <!-- Link to view Blog Titles -Edit Blog Posts -->
    <div class="container">
        <h2>Edit Blog Post</h2>
        <div class="container mt-5 mb-5">
            <a href="createBlogPost.php" class="btn btn-primary">Create Blog Post</a>
        </div>
        <div class="row row-cols-3 g-3">
            <?php foreach ($posts as $post): ?>
                <div class="col">
                    <div class="card border">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post['title'] ?></h5>
                            <a href="editBlog.php?id=<?= $post['id'] ?>" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- upload header image -->
    <div class="container mb-3 mt-5">
        <h2>Upload Header Image</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="header_image" class="form-label">Select Image:</label>
                <input type="file" class="form-control" id="header_image" name="header_image" accept="image/*" required>
            </div>
            <button name="change_image" type="submit" class="btn btn-primary">Upload Image</button>
        </form>
    </div>
    </div>
</body>

</html>