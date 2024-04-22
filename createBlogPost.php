
<?php

require('connect.php');
require('authenticate.php');

$errorMessage = "";

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if title, contentBlog, and author name are empty
    if (empty($_POST['title']) || empty($_POST['contentBlog']) || empty($_POST['author'])) {
        // Set error message
        $errorMessage = "Attention: Title, content, and author name are required!";
        // Validation error message in JS - following PDO requirement
        echo "<script>alert('$errorMessage');</script>";
    } else {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //tiny handling sanitization of blogContent field
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Image upload handling
        $image_post = "";
        if ($_FILES['image_blog']['error'] === UPLOAD_ERR_OK) {
            $tempFile = $_FILES['image_blog']['tmp_name'];
            $targetDir = 'uploads/';
            $targetFile = $targetDir . basename($_FILES['image_blog']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

          // Check file size (limit to 5MB)
          if ($_FILES['image_blog']['size'] > 5 * 1024 * 1024) {
            $errorMessage = "Image file is too large. Please upload an image under 5MB.";
            echo "<script>alert('$errorMessage');</script>";
        } // Allow certain file formats
        else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errorMessage = "Only JPG, JPEG, PNG & GIF files are allowed.";
            echo "<script>alert('$errorMessage');</script>";
        } else {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($tempFile, $targetFile)) {
                $image_post = $targetFile;
            } else {
                $errorMessage = "Error uploading the image.";
                echo "<script>alert('$errorMessage');</script>";
            }
        }
    }


        

        if (empty($errorMessage)) {
            // Build the parameterized SQL query
            $query = "INSERT INTO blog (title, contentBlog, author, image_post) VALUES (:title, :contentBlog, :author, :image_post)";
            $statement = $pdo->prepare($query);

            // Bind values to the parameters
            $statement->bindValue(':title', $title);
            $statement->bindValue(':contentBlog', $_POST['contentBlog']);
            $statement->bindValue(':author', $author);
            $statement->bindValue(':image_post', $image_post);

            // Execute the INSERT
            if ($statement->execute()) {
                // Success message if needed
            } else {
                // Display an error message in JS - following PDO requirement
                echo "<script>alert('Error creating the blog post.');</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/6du07rligevytivn166k977b47vxvwi6jix3bpe6vaycy8t7/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/path/or/uri/to/tinymce.min.js" referrerpolicy="origin"></script>
    <title>Create New Post</title>
</head>
<?php require('adminHeader.php'); ?>
<body>

<script src="/path/or/uri/to/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#mytextarea',
        license_key: 'gpl|<6du07rligevytivn166k977b47vxvwi6jix3bpe6vaycy8t7>'
      });
    </script>


    <div class="container">
        <h1>Create Blog Post</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
            <label for="contentBlog">Content</label>
            <textarea id="mytextarea" name="contentBlog" placeholder="Type here..."></textarea>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Author:</label>
                <input type="text" id="author" name="author" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="image_blog" class="form-label">Image:</label>
                <input type="file" id="image_blog" name="image_blog" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

 
</body>

</html>
