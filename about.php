<?php

require ('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About S&T Books</title>
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
            <p>Together, Sara and Thiago form the powerhouse that drives SET Books forward, setting new standards of
                excellence in accounting and bookkeeping. Join us on our journey as we transform numbers into narratives
                and empower businesses to write their financial success stories!</p>
            <div class="d-flex justify-content-around">
                <div class="team-member">
                    <img src="images/joseph-gonzalez-iFgRcqHznqg-unsplash.jpg" alt="Thiago Profile">
                    <p><strong>Thiago </strong>is the Maestro of Financial Records
                        Thiago, our co-owner and resident bookkeeper, is the maestro behind the scenes. With a
                        meticulous approach, he ensures that every financial record is not just maintained, but crafted
                        with precision. His dedication to accuracy and efficiency is unmatched, making him the backbone
                        of SET Books' financial operations. Thiago's expertise guarantees that our clients receive not
                        just a service, but a masterpiece of financial clarity.</p>
                </div>
                <div class="team-member">
                    <img src="images/jonathan-borba-5rQG1mib90I-unsplash.jpg" alt="Sara Profile">
                    <p><strong>Sara </strong>is the Architect of Financial Success
                        Sara is the visionary creator behind SET Books. With a keen eye for detail and a passion for
                        precision, she leads our team with grace and expertise. As an accountant, Sara ensures that
                        every number aligns perfectly, guiding our financial strategies with finesse. Her commitment to
                        excellence ensures that SET Books not only meets but exceeds industry standards, making us a
                        beacon of trust and reliability in the world of accounting.</p>
                </div>
            </div>
        </section>

        <section class="about">
            <h2>Mission Statement:</h2>
            <p>At S&T Books, our mission is to provide expert bookkeeping and personal tax return services while
                fostering a welcoming environment centered on trust, care, and genuine support. We are committed to
                delivering friendly, reliable, and judgment-free assistance, ensuring our clients feel valued and
                understood.</p>
            <h2>Vision Statement:</h2>
            <p>Our vision at S&T Books is to be the go-to destination for individuals seeking not just accounting
                services but a supportive partnership. We aspire to create lasting connections, becoming a trusted
                resource where clients feel comfortable, empowered, and appreciated, fostering relationships that
                transcend beyond mere transactions.</p>
            <h2>Core Values:</h2>
            <ul>
                <li><strong>Client-Centric Approach:</strong> We prioritize our clients' needs, offering personalized
                    services and dedicated support tailored to their unique situations.</li>
                <li><strong>Integrity and Confidentiality:</strong> We uphold the highest standards of integrity and
                    confidentiality, safeguarding our clients' information and trust.</li>
                <li><strong>Empathy and Understanding:</strong> We operate in a judgment-free zone, fostering an
                    environment of empathy, understanding, and inclusivity, where clients feel comfortable sharing their
                    concerns.</li>
                <li><strong>Expertise and Continuous Learning:</strong> We are committed to staying abreast of industry
                    changes and expanding our knowledge, ensuring the advice and services we provide are based on the
                    latest insights and best practices.</li>
                <li><strong>Building Lasting Relationships:</strong> Beyond professional transactions, we aim to build
                    enduring relationships based on mutual respect, trust, and friendship.</li>
                <li><strong>Reliable and Responsive:</strong> We strive for reliability in our services and
                    responsiveness in addressing our clients' needs promptly and effectively.</li>
            </ul>
        </section>
    </div>

</body>

<footer>
    <?php require ('footer.php'); ?>
</footer>

</html>