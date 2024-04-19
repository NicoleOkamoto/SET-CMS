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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input for edited content
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contentBlog = filter_input(INPUT_POST, 'contentBlog', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Validate inputs
    if (empty($title) || empty($contentBlog) || empty($author)) {
        $errorMessage = "Attention: Title, content, and author are required!";
    } else {
        // File upload validation
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
        }

        if (empty($errorMessage)) {
            $query = "UPDATE blog SET title = :title, contentBlog = :contentBlog, author = :author WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':contentBlog', $contentBlog);
            $statement->bindValue(':author', $author);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            // Redirect after update.
            header("Location: blogPost.php?id={$id}");
            exit;
        }
    }

    // Handle additional button actions
    if (isset($_POST['view_post'])) {
        // Handle view post action
        header("Location: blogPost.php?id={$id}");
        exit;
    } elseif (isset($_POST['submit_continue_editing'])) {
      
        header("Location: admin.php");
        exit;
    } elseif (isset($_POST['delete'])) {
        // Handle delete post action
        $query = "DELETE FROM blog WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        // Redirect to a relevant page after deletion
        header("Location: admin.php"); // Redirect to admin page for example
        exit;
    }
}

// Fetch comments for the blog post along with their IDs
$query = "SELECT id, name, comment FROM comments WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->bindValue(':post_id', $id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);


// Check if the form to delete a comment is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {
    // Get the comment ID from the form submission
    $comment_id = isset($_POST['comment_id']) ? $_POST['comment_id'] : null;

    // Check if the comment ID is valid
    if ($comment_id) {
        // Prepare the query to delete the comment from the database
        $delete_query = "DELETE FROM comments WHERE id = :comment_id";
        $delete_statement = $pdo->prepare($delete_query);

        // Bind the comment ID parameter
        $delete_statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);

        // Execute the deletion query
        if ($delete_statement->execute()) {
            // Comment deleted successfully
            // Redirect back to the same page or wherever appropriate
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            // Error occurred while deleting the comment
            echo "Error deleting comment.";
        }
    } else {
        // Invalid comment ID
        echo "Invalid comment ID.";
    }
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

<?php require('adminHeader.php'); ?>

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
            <label for="contentBlog" class="form-label">Content</label>
            <div id="editor" style="height: 300px;"><?= $post['contentBlog'] ?></div>
            <input type="hidden" name="contentBlog">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Current Image</label><br>
            <img src="<?= $post['image_post'] ?>" alt="Current Image" style="max-width: 100%; height: auto;">
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
            <button type="submit" class="btn btn-warning" name="submit_continue_editing">Submit and Continue Editing</button>
            <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Post</button>
    <input type="hidden" name="id" value="<?= $post['id'] ?>">
    <input type="hidden" name="delete" value="1"> <!-- Add a hidden input to indicate deletion -->
        </div>
    </form>

    <script>
    function confirmDelete() {
        if (confirm('Are you sure you wish to delete this post?')) {
            document.getElementById('deleteForm').submit(); // Submit the form
        }
    }
</script>


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
                        <form method="post">
                            <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                            <button type="submit" class="btn btn-danger" name="delete_comment">Delete</button>
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
