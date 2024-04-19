<?php

require('connect.php');

// Pagination configuration
$limit = 6; // Number of posts per page

// Retrieve the current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $limit;

// Fetch and display inserted data. Five most recent blog posts displayed in reverse chronological order.
$query = "SELECT SQL_CALC_FOUND_ROWS id, title, contentBlog, date, image_post, author FROM blog ORDER BY date DESC LIMIT :limit OFFSET :offset";
$statement = $pdo->prepare($query);
$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();

// Fetch total number of rows (for pagination)
$total_rows = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();

// Initialize variables
$error_message = '';
$search_results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    // Get the search query from the form and sanitize it
    $search_query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);

    // Perform the search in the title or contentBlog fields
    $query = "SELECT id, title, contentBlog, date FROM blog WHERE title LIKE :query OR contentBlog LIKE :query ORDER BY date DESC";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':query', "%$search_query%", PDO::PARAM_STR);
    $statement->execute();
    
    // Fetch the search results
    $search_results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any search results
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">
    <title>S&T Books Information Hub</title>
</head>

<body>
    
        <header>
            <?php require('header.php'); ?>
        </header>

        <h1 class="text-center mb-4">Info Hub:</h1>

        <!-- Search bar -->
        <form method="GET" class="search-container">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search for posts by title or content..." value="<?= isset($_GET['query']) ? $_GET['query'] : '' ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error_message ?>
            </div>
        <?php elseif (!empty($search_results)): ?>
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
        <?php endif; ?>
        <div class="container">
        <?php if ($statement->rowCount() > 0): ?>
            <!-- Display recent blog posts -->
            <div class="row justify-content-center">
                <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col-lg-12">
                        <div class='blog-post'>
                            <h2><a href='blogPost.php?id=<?= $row['id'] ?>'><?= $row['title'] ?></a></h2>
                            <small><?= date('F d, Y, h:i a', strtotime($row['date'])) ?></small>
                            <p>
                                <?php
                                $limitedcontent = strlen($row['contentBlog']) > 200 ? substr($row['contentBlog'], 0, 200) . '...' : $row['contentBlog'];
                                echo $limitedcontent;
                                ?>
                                <?php if (strlen($row['contentBlog']) > 200): ?>
                                    <a href='blogPost.php?id=<?= $row['id'] ?>' >Read Full Post</a>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php
                    $total_pages = ceil($total_rows / $limit);
                    $previous_page = $page > 1 ? $page - 1 : 1;
                    $next_page = $page < $total_pages ? $page + 1 : $total_pages;
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $previous_page ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $next_page ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
 
        <?php endif; ?>


    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <footer>
        <?php require('footer.php'); ?>
    </footer>
</body>

</html>
