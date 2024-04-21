<?php

require ('connect.php');

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
    <?php require ('header.php'); ?>

</header>

<body>
    <div class="container">
        <section class="about">
            <h2>Who we are?</h2>
            <p>S&T Books is a renowned Canadian firm based in Winnipeg specializing in providing expert accounting and
                personal tax return services. With a mission to create a welcoming environment centered on trust, care,
                and genuine support, S&T Books is committed to delivering friendly, reliable, and judgment-free
                assistance to its clients.</p>
        </section>

        <section class="team mb-3">
            <h2>Meet our Team</h2>
            <div class="d-flex justify-content-around">
                <div class="team-member">
                    <img src="images/joseph-gonzalez-iFgRcqHznqg-unsplash.jpg" alt="Thiago Profile">
                    <p><strong>Thiago </strong>is one of the co-owners of SET Books. He is a bookkeeper and ensures that
                        all financial records are accurately maintained.</p>
                </div>
                <div class="team-member">
                    <img src="images/jonathan-borba-5rQG1mib90I-unsplash.jpg" alt="Sara Profile">
                    <p><strong>Sara </strong>is the creator of SET Books. She is an accountant and oversees all
                        accounting activities, ensuring compliance with regulations.</p>
                </div>
            </div>
        </section>

        <section class="about">
            <h2>Mission Statement:</h2>
            <p>At S&T Books, our mission is to provide expert bookkeeping and personal tax return services while fostering a welcoming environment centered on trust, care, and genuine support. We are committed to delivering friendly, reliable, and judgment-free assistance, ensuring our clients feel valued and understood.</p>
            <h2>Vision Statement:</h2>
            <p>Our vision at S&T Books is to be the go-to destination for individuals seeking not just accounting services but a supportive partnership. We aspire to create lasting connections, becoming a trusted resource where clients feel comfortable, empowered, and appreciated, fostering relationships that transcend beyond mere transactions.</p>
            <h2>Core Values:</h2>
            <ul>
                <li><strong>Client-Centric Approach:</strong> We prioritize our clients' needs, offering personalized services and dedicated support tailored to their unique situations.</li>
                <li><strong>Integrity and Confidentiality:</strong> We uphold the highest standards of integrity and confidentiality, safeguarding our clients' information and trust.</li>
                <li><strong>Empathy and Understanding:</strong> We operate in a judgment-free zone, fostering an environment of empathy, understanding, and inclusivity, where clients feel comfortable sharing their concerns.</li>
                <li><strong>Expertise and Continuous Learning:</strong> We are committed to staying abreast of industry changes and expanding our knowledge, ensuring the advice and services we provide are based on the latest insights and best practices.</li>
                <li><strong>Building Lasting Relationships:</strong> Beyond professional transactions, we aim to build enduring relationships based on mutual respect, trust, and friendship.</li>
                <li><strong>Reliable and Responsive:</strong> We strive for reliability in our services and responsiveness in addressing our clients' needs promptly and effectively.</li>
            </ul>
        </section>
    </div>
    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<footer>
    <?php require('footer.php'); ?>
</footer>

</html>
