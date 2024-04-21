<?php


require('connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">
</head>
<header>
<?php require ('header.php');?>

</header>

<body>
    <div class="container">
        
        <section class="about">
            <h2>Who we are?</h2>
            <p>S&T Books is a renowned Canadian firm based in Winnipeg specializing in providing expert accounting and personal tax return services. With a mission to create a welcoming environment centered on trust, care, and genuine support, S&T Books is committed to delivering friendly, reliable, and judgment-free assistance to its clients.</p>
        </section>

        <section class="team mb-3">
            <h2>Meet our Team</h2>
            <div class="d-flex justify-content-around">
                <div class="team-member">
                    <img src="images/joseph-gonzalez-iFgRcqHznqg-unsplash.jpg" alt="Thiago Profile">
                    <p><strong>Thiago </strong>is one of the co-owners of SET Books. He is a bookkeeper and ensures that all financial records are accurately maintained.</p>
                </div>
                <div class="team-member">
                    <img src="images/jonathan-borba-5rQG1mib90I-unsplash.jpg" alt="Sara Profile">
                    <p><strong>Sara </strong>is the creator of SET Books. She is an accountant and oversees all accounting activities, ensuring compliance with regulations.</p>
                </div>
            </div>
        </section>
    </div>
    </div>
</body>
<footer>
<?php require ('footer.php'); ?> 
</footer>
</html>