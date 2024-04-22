<?php

require ('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
  <header>
    <?php require ('header.php'); ?>
  </header>

  <div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <!-- Business tax consulting -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (10).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Business Tax Consulting</h5>
            <p class="card-text">Rate per hour: $90</p>
          </div>
        </div>
      </div>
      <!-- Personal tax consulting -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (12).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Personal Tax Consulting</h5>
            <p class="card-text">Rate per hour: $70</p>
          </div>
        </div>
      </div>
      <!-- Includes basic tax slips, medical expenses, etc. -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (11).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Basic Tax Consulting</h5>
            <p class="card-text">Includes basic tax slips, medical expenses, provincial and federal credits, RRSP, and
              review of improvements for next tax year. <br> Rate: $160</p>
          </div>
        </div>
      </div>
      <!-- Adding a second adult -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (4).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Adding a Second Adult</h5>
            <p class="card-text">With same services: $90</p>
          </div>
        </div>
      </div>
      <!-- Per dependent -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (5).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Per Dependent</h5>
            <p class="card-text">Includes child benefits, medical, and other information pertinent on a case by case
              basis: $10</p>
          </div>
        </div>
      </div>
      <!-- Addition to basic service -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (6).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Addition to Basic Service</h5>
            <p class="card-text">When all bookkeeping properly done - Filing of T2125: $50</p>
          </div>
        </div>
      </div>
      <!-- Review for self-employment income -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (7).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Review for Self-Employment Income</h5>
            <p class="card-text">Due to bookkeeping being partially done. Rate of $50.00 per hour with a minimum of 2
              hours charged: $200</p>
          </div>
        </div>
      </div>
      <!-- Over $50,000 of investments -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (8).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Over $50,000 of Investments</h5>
            <p class="card-text">Out of Canada, disability claiming calculation, complicated tax situations: $50</p>
          </div>
        </div>
      </div>
      <!-- Amendment Fees -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (9).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Amendment Fees</h5>
            <p class="card-text">Due to misinformation from client: $50</p>
          </div>
        </div>
      </div>
      <!-- Returning Client Discount -->
      <div class="col">
        <div class="card h-100">
          <img src="images/set-services (2).png" class="card-img-top rounded-circle mx-auto mt-3" alt="services"
            style="width: 150px; height: 150px;">
          <div class="card-body text-center">
            <h5 class="card-title">Returning Client Discount</h5>
            <p class="card-text">Maximum of 20% of discount. <br> 10% first returning year, 2% each extra year</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <?php require ('footer.php'); ?>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-QFsmv5n1N7CkC2GvKc2UWBSpb2viFuxw2L4B7F39Gz5qH/cxq2m2L+1AksK/WyqT" crossorigin="anonymous">
    </script>
</body>

</html>