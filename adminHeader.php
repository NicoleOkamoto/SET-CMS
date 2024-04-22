<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S&T Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>

    <div class="container mt-3">
        <div class="bg-light py-2 d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <div class="logo">
                <a href="index.php">
                    <img src="images/SET-BOOKS.png" alt="Logo" height="90px">
                </a>
            </div>
            <!-- Heading -->
            <h1 class="mb-0 ml-auto pr-5 mr-3">Admin Portal</h1> <!-- Added mr-3 for right margin -->
        </div>

        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-lg navbar-light mt-3 mb-3">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">🔹Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">🔹About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog.php">🔹Info Hub</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
</body>

</html>