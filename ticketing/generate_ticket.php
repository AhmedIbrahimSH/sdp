<?php
require 'phpqrcode/qrlib.php';

// Set content type to PNG
header('Content-Type: image/png');

// Create a blank image for the ticket
$width = 600;
$height = 300;
$image = imagecreatetruecolor($width, $height);

// Set colors
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$gray = imagecolorallocate($image, 200, 200, 200);

// Fill the background with white
imagefilledrectangle($image, 0, 0, $width, $height, $white);

// Draw a vertical line to separate the event info and QR code
$line_x = $width / 2;
imageline($image, $line_x, 0, $line_x, $height, $gray);

// Add event details on the left side using the default font
$eventName = "Event: Tech Conference";
$eventDate = "Date: 2024-12-01";
$eventLocation = "Location: Cairo, Egypt";

imagestring($image, 5, 20, 50, $eventName, $black);
imagestring($image, 5, 20, 100, $eventDate, $black);
imagestring($image, 5, 20, 150, $eventLocation, $black);

// Generate a QR code
$qrTempFile = 'temp_qr.png';
QRcode::png("This is a QR Code", $qrTempFile, QR_ECLEVEL_L, 4);

// Load the QR code image
$qrImage = imagecreatefrompng($qrTempFile);
$qrSize = imagesx($qrImage);
$qrPosX = $line_x + 60;
$qrPosY = ($height - $qrSize) / 2;

// Copy the QR code onto the ticket
imagecopy($image, $qrImage, $qrPosX, $qrPosY, 0, 0, $qrSize, $qrSize);

// Delete the temporary QR code file
unlink($qrTempFile);

// Output the final ticket as PNG
imagepng($image);

// Free up memory
imagedestroy($image);
imagedestroy($qrImage);
?>
