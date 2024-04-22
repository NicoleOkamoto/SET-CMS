<?php
// Set the session cookie lifetime to 30 minutes
session_set_cookie_params(1800); // 30 minutes in seconds

session_name("admin_user");
session_start();

define('ADMIN_LOGIN', 'wally');
define('ADMIN_PASSWORD', 'mypass');

// Check if the session is authenticated and the window is closed
if (isset($_SESSION['is_authenticated']) && isset($_SESSION['window_closed'])) {
    // Clear all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header('Location: login.php');
    exit();
}

// Check if the user is not authenticated
if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated']) {
    if (
        !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
        || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)
        || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)
    ) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="Our Blog"');
        exit("Access Denied: Username and password required.");
    }

    $_SESSION['is_authenticated'] = true;
}

// Set the session expiration time to 30 minutes of inactivity
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();
