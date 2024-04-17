<?php // Set the session cookie lifetime to 30 minutes
session_set_cookie_params(60); // 30 minutes in seconds

session_start();

define('ADMIN_LOGIN', 'wally');
define('ADMIN_PASSWORD', 'mypass');

if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated']) {
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
        || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)
        || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="Our Blog"');
        exit("Access Denied: Username and password required.");
    }

    $_SESSION['is_authenticated'] = true;
}

// Set the session expiration time to 30 minutes of inactivity
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for this page
    session_destroy();   // destroy session data
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp