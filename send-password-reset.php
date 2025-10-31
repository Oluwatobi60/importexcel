<?php
require 'config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
        $email = $_POST['email'];
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
        $sql = "UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$token_hash, $expiry, $email]);
        if ($stmt->rowCount()) {
                require 'mailer.php';
                $mail->setFrom("tobestic53@gmail.com", "Ultimate Landmark School");
                $mail->addAddress($email);
                $mail->Subject = "Ultimate Landmark School Password Reset";
                $mail->Body = <<<END
                <div style='font-family:Montserrat,sans-serif;'>
                <h2 style='color:#185a9d;'>Ultimate Landmark School</h2>
                <p>Click <a href="http://staff.ultimatelandmarkschools.org/reset-password.php?token=$token">here</a> to reset your password.</p>
                <p>If you did not request this, please ignore this email.</p>
                </div>
                END;
                try {
                    $mail->send();
                    // Set a session message and redirect to index.php
                    session_start();
                    $_SESSION['reset_message'] = 'A password reset link has been sent to your email address.';
                    header('Location: index.php');
                    exit;
                } catch (Exception $e) {
                    $message = "<div class='alert alert-danger text-center'>Message could not be sent. Mailer error: {$mail->ErrorInfo}</div>";
                }
        } else {
                $message = "<div class='alert alert-warning text-center'>No user found with that email address.</div>";
        }
}
?>
