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

    // Insert the new user into the database
    $stmt = $pdo->prepare('INSERT INTO users (username, password, email, first_name, last_name, business_name) VALUES (:username, :password, :email, :first_name, :last_name, :business_name)');
    if ($stmt->execute(['username' => $username, 'password' => $password, 'email' => $email, 'first_name' => $firstName, 'last_name' => $lastName, 'business_name' => $businessName])) {
        echo "User created successfully.";
    } else {
        echo "Error creating user.";
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
            // Read the file contents and convert to LONGBLOB
            $imageData = file_get_contents($tempFile);

            // Update the header image in the database
            $query = "UPDATE settings SET header_image = :header_image WHERE id = 1";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':header_image', $imageData, PDO::PARAM_LOB);
            if ($statement->execute()) {
                $successMessage = "Header image updated successfully.";
                echo "<script>alert('$successMessage');</script>";
            } else {
                $errorMessage = "Error updating header image.";
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
        
        <button className="create_user" type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
</div>

</form>

<!-- Link to view Blog Titles -Edit Blog Posts -->
<div class="container">
        <h1>Edit Blog</h1>
        <div class="row row-cols-3 g-3">
            <?php foreach ($posts as $post) : ?>
                <div class="col">
                    <div class="card">
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
    <div class="container">
        <h1>Upload Header Image</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="header_image" class="form-label">Select Image:</label>
                <input type="file" class="form-control" id="header_image" name="header_image" accept="image/*" required>
            </div>
            <button className="change_image" type="submit" class="btn btn-primary">Upload Image</button>
        </form>
    </div>


</div>
</body>
</html>
