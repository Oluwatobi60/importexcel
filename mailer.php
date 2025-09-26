<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

//PHP mailer object passing in true to enable exceptions we'll be using an SMTP server
$mail = new PHPMailer(true);

//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Call the SMTP method
$mail->isSMTP();

//set SMTP property to true
$mail->SMTPAuth = true;
/* $mail->SMTPAuth = false; */

//configure the SMTP server

/* $mail->Host = "smtp.example.com"; */
$mail->SMTPSecure = 'ssl';
$mail->Host = "smtp.gmail.com";
 $mail->Port = 465; 
/* $mail->Port = 25; */
$mail->Username = "tobestic53@gmail.com";
$mail->Password = "raorwoaodylijsgy";

$mail->isHTML(true);

return $mail;




