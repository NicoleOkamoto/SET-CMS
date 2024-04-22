<?php
session_start();
//Captcha for blog post - comment section
// Generate a new random captcha code
$captchaCode = substr(md5(mt_rand()), 0, 6); // Generate a 6-character random string

// Store captcha code in session
$_SESSION['captcha'] = $captchaCode;

// Load the background image
$backgroundImage = imagecreatefrompng('images/captcha_background.png');

// Create a blank image
$image = imagecreatetruecolor(120, 40);

// Copy the background image onto the blank image
imagecopy($image, $backgroundImage, 0, 0, 0, 0, 120, 40);

// Set the text color
$textColor = imagecolorallocate($image, 255, 255, 255);
$fontSize = 16;
// Add the captcha code to the image
imagestring($image, 5, 20, 10, $captchaCode, $textColor);

// Set the content type header to display the image
header('Content-Type: image/png');

// Output the image as PNG
imagepng($image);

// Free up memory
imagedestroy($image);
imagedestroy($backgroundImage);
?>