<?php

require ('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Welcome to your S&T Books portal!</title>
</head>

<body>
    <header>
        <?php require ('header.php'); ?>
    </header>
    <div class="container mb-3">
        <h2>Welcome to your dashboard</h2>
        <p> We are currently working hard to enhance your experience. Soon, you will be able to access your past
            information and upload documents quickly and securely. Thank you for your patience and stay tuned for
            updates!</p>
        <p>This is a protected area. Only logged-in users can access this page.</p>
        <div class="text-center mt-5"> <!-- Center the image and add top margin -->
            <img src="images/Coming soon Access past information and upload documents securely..png"
                alt="Page under construction" class="img-fluid"> <!-- Make the image responsive -->
        </div>
    </div>
    <footer>
        <?php require ('footer.php'); ?>
    </footer>
</body>

</html>