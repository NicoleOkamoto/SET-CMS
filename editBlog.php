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
    <link rel="stylesheet" href="main.css">
    <title>Edit Blog Post!</title>
</head>

<body>

    <div class='wrapper'>
        <header>
            <a href="index.php"><img src="images/Nicole_Blog_Logo.png" alt="Logo" class="logo"></a>
            <nav>
                <ul>
                    <!-- New Post / Home Page button in the Nav Bar -->
                    <li><a href="index.php">Home</a></li>
                    <li><a href="createBlogPost.php">New Post</a></li>
                </ul>
            </nav>
        </header>

        <!-- Display form with title and content being edited -->
        <?php if ($post): ?>
            <form method="post">
                <label for="title">Title</label>
                <input id="title" name="title" value="<?= $post['title'] ?>">
                <label for="contentBlog">Content</label>
                <textarea id="contentBlog" name="contentBlog" placeholder="<?= $post['contentBlog'] ?>"></textarea>

                <!-- Display buttons Edit and Submit Update -->
                <div class="buttons-container">
                    <input type="submit" value="Submit Update">
                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                    <!-- Confirm if user wants to delete the post -->
                    <input type="submit" name="delete" value="Delete Post"
                        onclick="return confirm('Are you sure you wish to delete this post?')">
                </div>
            </form>
        <?php endif ?>

    </div>

</body>

</html>