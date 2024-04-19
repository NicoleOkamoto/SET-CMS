<?php
session_start();

// Generate a random string for the CAPTCHA (e.g., letters and numbers)
$captchaText = substr(md5(mt_rand()), 0, 6); // Adjust the length as needed

// Store the CAPTCHA value in the session
$_SESSION['captcha'] = $captchaText;

// Create the image
$captchaImage = imagecreatefrompng("images\captcha_background.png"); // Use your own background image

// Set text color to white
$textColor = imagecolorallocate($captchaImage, 255, 255, 255);

// Add the CAPTCHA text to the image
imagestring($captchaImage, 5, 10, 5, $captchaText, $textColor);

// Output the image to a data URL
ob_start();
imagepng($captchaImage);
$captchaImageData = ob_get_clean();
imagedestroy($captchaImage);

// Send the image data as a response
header('Content-type: image/png');
echo $captchaImageData;

