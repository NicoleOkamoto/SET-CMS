<?php
session_start();

// Verify CAPTCHA
if ($_POST['captcha'] !== $_SESSION['captcha']) {
    // CAPTCHA verification failed
    // Redirect back to the form or display an error message
    header('Location: form.php?error=captcha');
    exit;
}

// CAPTCHA verification succeeded
// Proceed with processing the form data
