<?php

require ('connect.php');

// Fetch and display inserted data. Five most recent blog posts displayed in reverse chronological order.
$query = "SELECT id, title, contentBlog, date FROM blog ORDER BY date DESC LIMIT 5";
$statement = $db->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my Blog!</title>
</head>

<body>
    <div class='wrapper'>

        <header>
          
            <nav>
                <ul>
                    <!-- New Post button in the Nav Bar -->
                    <li><a href="create.php">New Post</a></li>
                </ul>
            </nav>
        </header>

        <h1> Explore the Latest Posts: </h1>
        
        <?php if ($statement->rowCount() > 0): ?>

            <!-- Blog post titles link to full page for each post. (This link includes a GET parameter to specify the post id.) -->
            <?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
                <div class='blog_post'>
                    <!-- Title with link to full post -->
                    <h2><a href='post.php?id=<?= $row['id'] ?>'>
                            <?= $row['title'] ?>
                        </a> </h2>

                    <small>
                        <!-- Data formatation as per required format -->
                        <?php $date = strtotime($row['date']);
                        $dateFormated = date('F d, Y, h:i a', $date); ?>
                        <?= $dateFormated ?>
                        <a href='edit.php?id=<?= $row['id'] ?>'>Edit</a>
                    </small>

                    <!-- Truncate the content if it's larger than 200 characters -->
                    <p>
                        <?php
                        $limitedcontent = strlen($row['contentBlog']) > 200 ? substr($row['contentBlog'], 0, 200) . '...' : $row['contentBlog'];
                        echo $limitedcontent;
                        ?>
                        <!-- Display "Read More" link if content is truncated -->
                        <?php if (strlen($row['contentBlog']) > 200): ?>
                            <a href='post.php?id=<?= $row['id'] ?>'>Read Full Post</a>

                        <?php endif; ?>
                    </p>
                </div>

            <?php endwhile; ?>

        <?php else: ?>
            
            <p> No posts yet. Be the first to share your thoughts and experiences! </p>

        <?php endif; ?>

    </div>

</body>

</html>