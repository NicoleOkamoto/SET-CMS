<?php

require ('connect.php');

// Pagination for blogs
// Pagination configuration - 6 posts per page
$limit = 6;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$offset = ($page - 1) * $limit;

// Fetch and display inserted data. Six most recent blog posts displayed in reverse chronological order.
$query = "SELECT SQL_CALC_FOUND_ROWS id, title, contentBlog, date, image_post, author FROM blog ORDER BY date DESC LIMIT :limit OFFSET :offset";
$statement = $pdo->prepare($query);
$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();

// Fetch total number of rows (for pagination)
$total_rows = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();


$error_message = '';
$search_results = [];

//Search bar for blog content and titles
//sanitize get for id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    // Get the search query from the form and sanitize it
    $search_query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);

    // Perform the search in the title or contentBlog fields
    $query = "SELECT id, title, contentBlog, image_post, date FROM blog WHERE title LIKE :query OR contentBlog LIKE :query ORDER BY date DESC";
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


<?php require ('header.php'); ?>


<body>
    <h1 class="text-center mb-4 mt-2">Info Hub:</h1>

    <div class="col-md-8 offset-md-2 mb-3">
        <p class="text-break">Welcome to our bookkeeping and tax filing blog and information hub! Here, you'll
            find a wealth of valuable articles and resources to help you manage your finances effectively.
            Whether you're a business owner looking for tax-saving strategies or an individual navigating
            personal finances, our expertly crafted content is designed to provide you with insights and tips
            tailored to your needs. Stay informed, stay ahead!</p>
    </div>


    <!-- Display search bar for blog posts titles and content -->
    <form method="GET" class="search-container mb-3">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Search for posts by title or content..."
                value="<?= isset($_GET['query']) ? $_GET['query'] : '' ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Display error message if available -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error_message ?>
        </div>
    <?php elseif (!empty($search_results)): ?>

        <!-- Display search results -->
        <div class="row m-3">
            <?php foreach ($search_results as $result): ?>


                <div class="col-lg-6"> <!-- Use column grid for consistent layout -->
                    <div class="container-card text-center p-3 m-3">
                        <a href='blogPost.php?id=<?= $result['id'] ?>'
                            style="display: flex; justify-content: center; align-items: center;">
                            <div class="image-container" style="background-image: url('<?= $result['image_post'] ?>');"></div>
                        </a>

                        <div class="card-body">
                            <h5 class="card-title mr-3 ml-3 p-2"><a style="text-decoration: none;"
                                    href='blogPost.php?id=<?= $result['id'] ?>'><?= $result['title'] ?></a></h5>
                            <small class="text-muted"><?= date('F d, Y, h:i a', strtotime($result['date'])) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


    <!-- Blog Posts -->
    <div class="row m-3">
        <?php $count = 0; ?>
        <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
            <?php if ($count % 2 == 0): ?>
            </div>
            <div class="row">
            <?php endif; ?>
            <div class="col-lg-6">
                <div class="container-card text-center p-3 m-3">
                    <a href='blogPost.php?id=<?= $row['id'] ?>'
                        style="display: flex; justify-content: center; align-items: center;">
                        <div class="image-container" style="background-image: url('<?= $row['image_post'] ?>');"></div>
                    </a>


                    <div class="card-body">
                        <h5 class="card-title mr-3 ml-3 p-2"><a style="text-decoration: none;"
                                href='blogPost.php?id=<?= $row['id'] ?>'><?= $row['title'] ?></a></h5>
                        <small class="text-muted"><?= date('F d, Y, h:i a', strtotime($row['date'])) ?></small>
                    </div>
                </div>
            </div>
            <?php $count++; ?>
        <?php endwhile; ?>
    </div>


    <style>
        .image-container {
            height: 200px !important;
            /* Set the height of the container */
            width: 600px !important;
            /* Set the width of the container */
            background-size: cover !important;
            /* Cover the entire container */
            background-position: center !important;
            /* Center the image within the container */
        }
    </style>



    <!-- Pagination Nav Bar -->
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
                <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link"
                        href="?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $next_page ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Bootstrap JavaScript and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php require ('footer.php'); ?>

</body>

</html>