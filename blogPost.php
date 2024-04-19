<?php
require('connect.php');

// Get the blog post ID from the URL
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

if ($id === false || $id === null) {
    // If ID is not an integer or null, redirect to home page
    header("Location: index.php");
    exit;
}

// Query to fetch the blog post with the specified ID
$query = "SELECT title, date, contentBlog, image_post, author FROM blog WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();

// Fetch the blog post corresponding to the ID
$row = $statement->fetch(PDO::FETCH_ASSOC);

// Check if the blog post exists
if (!$row) {
    // If post not found, display JS alert
    $errorMessage = "Blog Post not found!";
    // Display validation error message in JS
    echo "<script>alert('$errorMessage'); window.location='index.php';</script>";
    exit;
}

// Set the page title to the blog post title
$pageTitle = $row['title'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">
    <title><?= $pageTitle ?></title>
</head>

<body>
    <?php require('header.php'); ?>

    <!-- Blog Post Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="blog_post">
                    <!-- Display the blog post -->
                    <h1><?= $row['title'] ?></h1>
                    <?php if ($row['image_post']) : ?>
                        <img src="<?= $row['image_post'] ?>" class="img-fluid mb-4" alt="Blog Post Image" />
                    <?php endif; ?>
                    <p class="mb-2"><small><?= date('F d, Y, h:i a', strtotime($row['date'])) ?></small></p>
                    <?= $row['contentBlog'] ?>
                    <h5><?= $row['author'] ?></h5>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php require('footer.php'); ?>
    </footer>
</body>

</html>