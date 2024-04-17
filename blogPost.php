<?php

/*******w******** 
    
    Name: Nicole Aline Okamoto Goncalves    
    Date: 04/01/2026
    Description: Blog Appplication Assigment 
  
****************/

require ('connect.php');

// Get the blog post ID from the URL
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

if ($id === false || $id === null) {
    // If ID is not an integer or null, redirect to home page
    header("Location: index.php");
    exit;
}

// Query to fetch the blog post with the specified ID
$query = "SELECT title, date, contentBlog FROM blog WHERE id = :id";
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
    <link rel="stylesheet" href="main.css">
    <title>
        <?= $pageTitle ?>
    </title>
</head>

<body>

    <div class='wrapper'>
        <!-- Remember that alternative syntax is good and html inside php is bad -->
        <header>
            <a href="index.php"><img src="images/Nicole_Blog_Logo.png" alt="Logo" class="logo"></a>
            <nav>
                <ul>
                    <!-- Home button -->
                    <li><a href="index.php">Home</a></li>
                    
                </ul>
            </nav>
        </header>

        <div class='blog_post'>
            <!-- Display the blog post -->
            <small>
                <h1>
                    <?= $row['title'] ?>
                </h1>
                <p>
                    <!-- Data formatation as per required format -->
                    <?php $date = strtotime($row['date']);
                    $dateFormated = date('F d, Y, h:i a', $date); ?>
                    <?= $dateFormated ?>
                </p>
            </small>
            <p>
                <?= $row['contentBlog'] ?>
            </p>
            <!-- Edit Post Button -->
            <a href='editBlogPost.php?id=<?= $id ?>' class="edit-button">Edit Post</a>

        </div>
    </div>
</body>

</html>