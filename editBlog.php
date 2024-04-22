<?php
require('connect.php');
require('authenticate.php');

$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

if ($id === false || $id === null) {
    header("Location: admin.php");
    exit;
}

$errorMessage = "";

$query = "SELECT * FROM blog WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

if (!$post) {
    $errorMessage = "Blog Post not found!";
}

// Handle form submission for editing the blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update'])) {
    // Sanitize user input for edited content
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contentBlog = filter_input(INPUT_POST, 'contentBlog', FILTER_SANITIZE_STRING);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $image_post= "";

    // Validate inputs
    if (empty($title) || empty($contentBlog) || empty($author)) {
        $errorMessage = "Attention: Title, content, and author are required!";
    } else {
        if ($_FILES['image']['name']) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES['image']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $uploadOk = 1;
        
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check === false) {
                $errorMessage = "File is not an image.";
                $uploadOk = 0;
            } elseif ($_FILES['image']['size'] > 500000) {
                $errorMessage = "Sorry, your file is too large.";
                $uploadOk = 0;
            } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                $errorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        
            if ($uploadOk == 1 && !move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $errorMessage = "Sorry, there was an error uploading your file.";
            }
        
            // Update image_post if upload was successful
            if ($uploadOk == 1) {
                $image_post = $targetFile;
            }
        }
        
        if (empty($errorMessage)) {
            $query = "UPDATE blog SET title = :title, contentBlog = :contentBlog, author = :author, image_post = :image_post WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':contentBlog', $_POST['contentBlog']);
            $statement->bindValue(':author', $author);
            $statement->bindValue(':image_post', $image_post); // Update image_post with new file path
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        
            // Redirect after update.
            header("Location: blogPost.php?id={$id}");
            exit;
        }
}
}

// Handle delete action for posts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM blog WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Redirect to admin page after deletion
    header("Location: admin.php");
    exit;
}

// Fetch comments for the blog post along with their IDs
$query = "SELECT id, name, comment FROM comments WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':post_id', $id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

// Handle delete action for comments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id'])) {
    $comment_id = filter_input(INPUT_POST, 'delete_comment_id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM comments WHERE id = :comment_id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    $statement->execute();

    // Redirect back to the same page or wherever appropriate
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $id);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/6du07rligevytivn166k977b47vxvwi6jix3bpe6vaycy8t7/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <title>Edit Blog Post</title>
</head>

<body>

<?php require('adminHeader.php'); ?>

<script src="https://cdn.tiny.cloud/1/6du07rligevytivn166k977b47vxvwi6jix3bpe6vaycy8t7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#mytextarea',
        license_key: 'gpl|<6du07rligevytivn166k977b47vxvwi6jix3bpe6vaycy8t7>'
    });
</script>

<!-- Display form with title, author, content, and image being edited -->
<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $post['title'] ?>">
    </div>
    <div class="mb-3">
        <label for="author" class="form-label">Author</label>
        <input type="text" class="form-control" id="author" name="author" value="<?= $post['author'] ?>">
    </div>
    <div class="mb-3">
        <label for="contentBlog">Content</label>
        <textarea id="mytextarea" name="contentBlog" placeholder="Type here..."><?= $post['contentBlog'] ?></textarea>
    </div>
    <div class="mb-3">
    <label for="image" class="form-label">Current Image</label><br>
    <img src="<?= $post['image_post'] ?>" alt="Current Image" style="max-width: 300px; height: auto;">
</div>

    <div class="mb-3">
        <label for="image" class="form-label">Edit Image</label><br>
        <input type="file" class="form-control" id="image" name="image">
    </div>

    <!-- Display buttons Edit and Submit Update -->
    <div class="mb-3">
        <!-- Display error message if there is one -->
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMessage ?>
            </div>
        <?php endif ?>
        <button type="submit" class="btn btn-primary" name="submit_update">Submit Update & Exit</button>
        <button type="submit" class="btn btn-danger" name="delete_post">Delete Post</button>

        <input type="hidden" name="id" value="<?= $post['id'] ?>">
    </div>
</form>

<!-- Display Comments -->
<div class="container mt-5">
    <div class="comments">
        <h5 class="mb-4">Comments:</h5>
        <?php if (count($comments) > 0) : ?>
            <?php $colors = ['#FFE4C2', '#FFF7F2']; ?>
            <?php $colorIndex = 0; ?>
            <?php foreach ($comments as $comment) : ?>
                <div class="card mb-3" style="background-color: <?= $colors[$colorIndex % count($colors)] ?>;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $comment['name'] ?></h5>
                        <p class="card-text"><?= $comment['comment'] ?></p>
                        <!-- Display delete button for each comment -->
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="delete_comment_id" value="<?= $comment['id'] ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                <?php $colorIndex++; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No comments on this post!</p>
        <?php endif; ?>
    </div>
</div>

</body>

</html>
