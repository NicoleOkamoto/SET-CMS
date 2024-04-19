<?php


require('connect.php');

require ('header.php');
// Fires off a session cookie


$verified_user = isset($_SESSION['is_verified']) && $_SESSION['is_verified'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">
    <!-- Image with contact form -->
    <div class="image-wrapper">
        <?php
        // Fetch the latest header image from the database
        $query = "SELECT header_image FROM settings ORDER BY id DESC LIMIT 1";
        $statement = $pdo->query($query);
        
        // Check if any rows were returned
        if ($statement->rowCount() > 0) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $headerImage = $row['header_image'];
            
            // Output the image directly
            echo '<img src="data:image/jpeg;base64,' . base64_encode($headerImage) . '" class="img-fluid cropped-image" alt="">';
        } else {
            echo '<p>No header image found.</p>';
        }
        ?>

        <div class="overlay">
            <div class="form-container">
                <!-- Captcha form -->
                <script src="https://web3forms.com/client/script.js" async defer></script>
                <form class="form-container" id="myForm" action="https://api.web3forms.com/submit" method="POST">
                    <input type="hidden" name="access_key" value="e5cbb0ea-9a92-40d9-b437-7e92202582e4">
                    <label class="form-title">Book a Free Consultation!</label>
                    <input class="form-control mb-3" type="text" name="name" placeholder="Name" required>
                    <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
                    <textarea class="form-control mb-3" name="message" rows="3" placeholder="Tell us about your needs!" required></textarea>
                    <div class="h-captcha" data-captcha="true"></div>
                    <button class="btn btn-primary" type="submit">Submit Form</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
<div class="container-fluid py-5 bg-light">
    <h1 class="mb-4 text-center .text-secondary">Our Services</h1>
    <div class="row">
        <!-- Personal File Tax -->
        <div class="col-md-3">
            <div class="card bg-white h-100 mb-4">
                <img src="images/luana-azevedo-2X0Set_oSh8-unsplash.jpg" alt="Personal File Tax" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Personal File Tax</h5>
                    <p class="card-text">Experience personalized care with our Personal File Tax service. Our dedicated team provides attentive guidance to ensure your tax returns are handled with precision and care. With innovative solutions tailored to your needs, we maximize deductions and optimize your tax outcomes, all while providing a welcoming and supportive environment.</p>
                </div>
            </div>
        </div>
        <!-- Business File Tax -->
        <div class="col-md-3">
            <div class="card bg-white h-100 mb-4">
                <img src="images/priscilla-du-preez-nNMBa7Y1Ymk-unsplash.jpg" alt="Business File Tax" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Business File Tax</h5>
                    <p class="card-text">Entrust your business tax needs to us and experience professional excellence. Our Business File Tax service offers meticulous attention to detail, ensuring compliance and minimizing tax liabilities. We blend professionalism with innovation, leveraging cutting-edge strategies to enhance your business's financial health and success.</p>
                </div>
            </div>
        </div>
        <!-- Finance Audit -->
        <div class="col-md-3">
            <div class="card bg-white h-100 mb-4">
                <img src="images/kelly-sikkema-SiOW0btU0zk-unsplash.jpg" alt="Finance Audit" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Finance Audit</h5>
                    <p class="card-text">Elevate your financial processes with our Finance Audit service. Our attentive approach ensures thorough scrutiny of your financial records, uncovering insights to drive growth and efficiency. With our innovative audit techniques, we provide valuable recommendations to strengthen your financial integrity and propel your business forward.</p>
                </div>
            </div>
        </div>
        <!-- Bookkeeping -->
        <div class="col-md-3">
            <div class="card bg-white h-100 mb-4">
                <img src="images/brooke-cagle-9fHMo1-5Io8-unsplash.jpg" alt="Bookkeeping" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Bookkeeping</h5>
                    <p class="card-text">Experience the freedom to excel in what you do best, while we handle the rest with our Bookkeeping service. Our attentive bookkeepers meticulously manage your financial data, providing a solid foundation for informed decision-making. With our innovative tools and personalized approach, we streamline your bookkeeping processes, freeing up your time and energy to concentrate on growing your business.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="services.php" class="btn btn-primary btn-lg mt-5">Learn More About Our Services</a>
    </div>
</div>
                </div>

<!-- Include Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Customers Review Carousel -->
<div id="googleReviewCarousel" class="carousel slide" data-ride="carousel">
    <!-- Title -->
    <h3 class="text-center">What our customers are saying:</h3>

    <div class="carousel-inner mr-5 ml-5">
        <!-- Review 1 -->
        <div class="carousel-item active pd-5 mb-5">
            <div class="carousel-content mr-5 ml-5">
                <h4 class="text-center">Oh My-Donuts</h3>
                <div class="rating text-center">
                    ★★★★★
                </div>
                <p class="text-center italic">""S&T Books exceeded my expectations with their Enterprise Finance Audit service. Their team demonstrated exceptional attention to detail and professionalism throughout the auditing process. They provided valuable insights that helped us optimize our financial strategies and improve our overall efficiency. I highly recommend S&T Books to any enterprise seeking thorough and reliable financial audit services.""</p>
            </div>
        </div>
        <!-- Review 2 -->
        <div class="carousel-item">
            <div class="carousel-content">
                <h4 class="text-center">Renan Luis</h3>
                <div class="rating text-center">
                    ★★★★★
                </div>
                <p class="text-center italic">""Choosing S&T Books for my personal file tax needs was one of the best decisions I've made. Their dedicated team provided personalized assistance and guidance, ensuring that my tax returns were handled accurately and efficiently. They helped me maximize deductions and minimize tax liabilities, resulting in significant savings. With their expertise and attention to detail, tax season has become stress-free for me. Thank you, S&T Books, for your exceptional service!""</p>
            </div>
        </div>
        <!-- Review 3 -->
        <div class="carousel-item">
            <div class="carousel-content">
                <h4 class="text-center">Barber Shop Transcona</h3>
                <div class="rating text-center">
                    ★★★★★
                </div>
                <p class="text-center italic">""S&T Books has been instrumental in managing my business's bookkeeping needs. Their comprehensive bookkeeping service has streamlined our financial processes and provided us with valuable insights into our financial health. Their team is attentive, reliable, and always goes above and beyond to ensure accuracy and efficiency. Thanks to S&T Books, I can focus on growing my business with confidence, knowing that our finances are in capable hands.""</p>
            </div>
        </div>
    </div>
    <!-- Next/Prev controls -->
    <a class="carousel-control-prev" href="#googleReviewCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#googleReviewCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Custom JavaScript -->
<script>
    // Activate carousel and set interval
    $('.carousel').carousel({
        interval: 4000  // Slide every 4 seconds
    });
</script>

<!-- Custom CSS -->
<style>
    .carousel-content {
        text-align: center;
    }
    .rating {
        color: gold;
        font-size: 24px;
    }
    .italic {
        font-style: italic;
    }
    h3 {
        font-size: 18px;
        margin-bottom: 5px;
    }
</style>



<footer>
    <!-- Footer content -->
    <?php require ('footer.php'); ?>
</footer>

<script src="script.js"></script>

</body>
</html>
