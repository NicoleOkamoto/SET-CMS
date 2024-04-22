<?php

require ('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S%T Books Contact Us!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">

</head>

<body>
    <header>
        <?php require ('header.php'); ?>
    </header>

    <div class="container mt-3 mb-3">
        <!-- Image with contact form -->
        <div class="image-wrapper">
            <img src="images/thomas-lefebvre-gp8BLyaTaA0-unsplash.jpg" class="img-fluid cropped-image" alt="">

            <div class="overlay">
                <div class="form-container">
                    <!-- Captcha form -->
                    <script src="https://web3forms.com/client/script.js" async defer></script>
                    <form class="form-container" id="myForm" action="https://api.web3forms.com/submit" method="POST">
                        <input type="hidden" name="access_key" value="e5cbb0ea-9a92-40d9-b437-7e92202582e4">
                        <input class="form-control mb-3" type="text" name="name" placeholder="Name" required>
                        <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
                        <textarea class="form-control mb-3" name="message" rows="3"
                            placeholder="Tell us about your needs!" required></textarea>
                        <div class="h-captcha" data-captcha="true"></div>
                        <button class="btn btn-primary" type="submit">Submit Inquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php require ('footer.php'); ?>
    </footer>
</body>

</html>