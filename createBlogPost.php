<?php

require ('connect.php');
require ('authenticate.php');


$errorMessage = "";

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if title or contentBlog is empty
    if (empty($_POST['title']) || empty($_POST['contentBlog'])) {
        // Set error message
        $errorMessage = "Attention: Title and content are required!";
        // Validation error message in JS - following PDO requirement 
        echo "<script>alert('$errorMessage');</script>";
    } else {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $contentBlog = filter_input(INPUT_POST, 'contentBlog', FILTER_SANITIZE_STRING);

        // Build the parameterized SQL query
        $query = "INSERT INTO blog (title, contentBlog) VALUES (:title, :contentBlog)";
        $statement = $pdo->prepare($query);

        // Bind values to the parameters
        $statement->bindValue(':title', $title);
        $statement->bindValue(':contentBlog', $contentBlog);

        // Execute the INSERT
        if ($statement->execute()) {
            // Success message if needed
        } else {
            // Display an error message in JS - following PDO requirement 
            echo "<script>alert('Error creating the blog post.');</script>";
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <!-- Include Quill Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class='container'>
        <header class="bg-light py-2 d-flex justify-content-between align-items-center px-3 mb-3">
            <!-- Logo -->
            <div class="logo">
                <img src="images/SET-BOOKS.png" alt="Logo" height="90px">
            </div>
            
        </header>


        <h1>Create a new Blog Post</h1>
        
        <!-- Create the editor container for the title -->
        <div id="titleEditor" class="mb-3"></div>

        <!-- Create the editor container for the contentBlog -->
        <div id="contentEditor" class="mb-3"></div>

        <!-- Form to submit new post -->
        <form method="post" action="createBlogPost.php">
            <!-- Hidden input field to store Quill content of title -->
            <input type="hidden" id="titleInput" name="title">
            <!-- Hidden input field to store Quill content of contentBlog -->
            <input type="hidden" id="contentBlogInput" name="contentBlog">
            <button type="submit" class="btn btn-primary">Create New Post</button>
        </form>
    </div>

    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>

    <!-- Initialize Quill editor for title -->
    <script>
        const titleEditor = new Quill('#titleEditor', {
            theme: 'snow',
            placeholder: 'Enter title...'
        });
    </script>

    <!-- Initialize Quill editor for contentBlog -->
    <script>
        const contentEditor = new Quill('#contentEditor', {
            theme: 'snow',
            placeholder: 'Enter content...'
        });

        // Listen for form submission
        document.querySelector('form').addEventListener('submit', function() {
            // Populate the hidden input field with Quill content of title
            document.querySelector('#titleInput').value = titleEditor.root.innerHTML;
            // Populate the hidden input field with Quill content of contentBlog
            document.querySelector('#contentBlogInput').value = contentEditor.root.innerHTML;
        });
    </script>
</body>
</html>