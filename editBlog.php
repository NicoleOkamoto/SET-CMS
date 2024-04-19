<?php

/*******w******** 
    
    Name: Nicole Aline Okamoto Goncalves    
    Date: 04/01/2026
    Description: Blog Appplication Assigment 

****************/

require ('connect.php');
require ('authenticate.php');

// Retrieve and sanitize the ID parameter from GET
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

$errorMessage = "";

if ($id === false || $id === null) {

    // If ID is not an integer or null, redirect to home page
    header("Location: index.php");
    exit;
}

// Fetch the blog post corresponding to the ID
$query = "SELECT * FROM blog WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

// Check if the blog post exists
if (!$post) {

    // If post not found, display JS alert
    $errorMessage = "Blog Post not found!";
    // Display validation error message in JS
    echo "<script>alert('$errorMessage'); window.location='index.php';</script>";
    exit;
}

// Handle form submission for deleting the blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['id'])) {

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "DELETE FROM blog WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Redirect to home page after deleting.
    header("Location: index.php");
    exit;
}

// Handle form submission for editing the blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['contentBlog']) && isset($_POST['id'])) {

    // Sanitize user input for edited content
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contentBlog = filter_input(INPUT_POST, 'contentBlog', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Check if title or contentBlog is empty
    if (empty($title) || empty($contentBlog)) {

        $errorMessage = "Attention: Title and content are required!";
        // Display validation error message in JS and return to the edit plage
        echo "<script>alert('$errorMessage'); window.location='editBlogPost.php?id={$id}';</script>";
        exit;
    }

    // Update the blog post in the database
    $query = "UPDATE blog SET title = :title, contentBlog = :contentBlog WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':contentBlog', $contentBlog);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Redirect after update.
    header("Location: blogPost.php?id={$id}");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Quill.js CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <header>
            <nav class="navbar navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="images/Nicole_Blog_Logo.png" alt="Logo" height="30" class="d-inline-block align-top">
                    </a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="createBlogPost.php">New Post</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Display form with title and content being edited -->
        <?php if ($post): ?>
            <form method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= $post['title'] ?>">
                </div>
                <div class="mb-3">
                    <label for="contentBlog" class="form-label">Content</label>
                    <div id="editor" style="height: 300px;"><?= $post['contentBlog'] ?></div>
                    <input type="hidden" name="contentBlog">
                </div>
                <!-- Display buttons Edit and Submit Update -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit Update</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Post</button>
                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                </div>
            </form>
        <?php endif ?>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Quill.js -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    // Set the initial content of the Quill editor
    quill.root.innerHTML = <?= json_encode($post['contentBlog']) ?>;

    // Save the Quill content to the hidden input field
    document.querySelector('form').addEventListener('submit', function() {
        document.querySelector('input[name="contentBlog"]').value = quill.getText();
    });

    // Confirm delete post action
    function confirmDelete() {
        if (confirm('Are you sure you wish to delete this post?')) {
            document.querySelector('input[name="delete"]').value = true;
            document.querySelector('form').submit();
        }
    }
</script>


</body>

</html>
