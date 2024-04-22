<?php
require ('connect.php');

// Fetch and display inserted data. All blog posts displayed in reverse chronological order.
$query = "SELECT id, title, contentBlog, date, image_post, author FROM blog ORDER BY date DESC";
$statement = $pdo->prepare($query);
$statement->execute();

$error_message = '';
$search_results = [];

// Search bar for blog content and titles
// Sanitize get for id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    // Get the search query from the form and sanitize it
    $search_query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);

    // Perform the search in the title or contentBlog fields
    $query = "SELECT id, title, contentBlog, date FROM blog WHERE title LIKE :query OR contentBlog LIKE :query ORDER BY date DESC";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':query', "%$search_query%", PDO::PARAM_STR);
    $statement->execute();

    $search_results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any search results, display error message otherwise.
    if (empty($search_results)) {
        $error_message = 'No results found. Please try again with a different search term.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S&T Books Info Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
<header>
    <?php require ('header.php'); ?>
</header>

<div class="container mt-5">
    <!-- Display error message if there are no search results -->
    <?php if (empty($search_results)): ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="alert alert-danger" role="alert">
                    No results found.
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Display search results -->
    <?php foreach ($search_results as $result): ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class='blog-post'>
                    <h2><a href='blogPost.php?id=<?= $result['id'] ?>'><?= $result['title'] ?></a></h2>
                    <small><?= date('F d, Y, h:i a', strtotime($result['date'])) ?></small>
                    <p><?= $result['contentBlog'] ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Display error message if there was an error fetching blog posts -->
    <?php if (!$statement->rowCount()): ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="alert alert-danger" role="alert">
                    Error fetching blog posts.
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Display blog posts -->
    <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <img src="<?= $row['image_post'] ?>" class="card-img-top" alt="Thumbnail Image" style="max-height: 200px; width: auto;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['title'] ?></h5>
                        <small class="text-muted"><?= date('F d, Y, h:i a', strtotime($row['date'])) ?></small>
                        <p class="card-text"><?= strlen($row['contentBlog']) > 200 ? substr($row['contentBlog'], 0, 200) . '...' : $row['contentBlog'] ?></p>
                        <?php if (strlen($row['contentBlog']) > 200): ?>
                            <a href='blogPost.php?id=<?= $row['id'] ?>' class="btn btn-primary">Read Full Post</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
