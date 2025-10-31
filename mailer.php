<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

//PHP mailer object passing in true to enable exceptions we'll be using an SMTP server

$mail = new PHPMailer(true);
// $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable for debugging
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465; // Use 465 for SSL (ENCRYPTION_SMTPS)
$mail->Username = 'tobestic53@gmail.com';
$mail->Password = 'raorwoaodylijsgy'; // Consider using an environment variable for security
$mail->setFrom('tobestic53@gmail.com', 'Salary Web Portal');
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';

return $mail;




