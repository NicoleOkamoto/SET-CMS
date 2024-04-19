<?php
require('connect.php');


// Generate random captcha code
$captchaCode = substr(md5(mt_rand()), 0, 6); // Generate a 6-character random string

// Store captcha code in session
$_SESSION['captcha'] = $captchaCode;




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

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_comment'])) {
        // Comment submission is coming from the button with name "submit_comment"
        $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
        $comment = isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : '';

        // Insert the comment into the database
        $query = "INSERT INTO comments (post_id, name, comment) VALUES (:post_id, :name, :comment)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':post_id', $id, PDO::PARAM_INT);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':comment', $comment);
        $statement->execute();
    }
}
// Fetch comments for the blog post
$query = "SELECT name, comment FROM comments WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':post_id', $id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);
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
<header>
<?php require('header.php'); ?>
</header>
<body>
 <!-- Blog Post Content -->

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="blog_post bg-light p-4 rounded">
                <!-- Display the blog post -->
                <h1 class="mb-4"><?= $row['title'] ?></h1>
                <?php if ($row['image_post']) : ?>
                    <img src="<?= $row['image_post'] ?>" class="img-fluid mb-4" alt="Blog Post Image" />
                <?php endif; ?>
                <p class="mb-2"><small><?= date('F d, Y, h:i a', strtotime($row['date'])) ?></small></p>
                <?= $row['contentBlog'] ?>
                <h5 class="mt-4"><?= $row['author'] ?></h5>
            </div>
<!-- Display Comments -->
<div class="comments mt-5">
    <h5 class="mb-4">Comments:</h5>
    <?php if (count($comments) > 0) : ?>
        <?php $colors = ['#FFE4C2', '#FFF7F2']; ?>
        <?php $colorIndex = 0; ?>
        <?php foreach ($comments as $comment) : ?>
            <div class="card mb-3" style="background-color: <?= $colors[$colorIndex % count($colors)] ?>;">
                <div class="card-body">
                    <h5 class="card-title"><?= $comment['name'] ?></h5>
                    <p class="card-text"><?= $comment['comment'] ?></p>
                </div>
            </div>
            <?php $colorIndex++; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>
</div>


            <!-- Comment Form -->
            <div class="comment-form mb-3 mt-5">
                <h3 class="mb-4">Add a Comment</h3>
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="captcha" class="form-label">Captcha</label>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="captcha.php" alt="Captcha Image" class="img-fluid">
                           
                                <input type="text" class="form-control" id="captcha" name="captcha" required>
                                <small class="form-text">Enter the code shown above</small>
                            </div>
                        </div>
                    </div>
                    <button name="submit_comment" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>


  
    <footer>
        <?php require('footer.php'); ?>
    </footer>
</body>

</html>
