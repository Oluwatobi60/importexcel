<?php

require 'config.php';

// Check if email is set in the POST data
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Generate token and hash
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);

    // Calculate expiry time
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // Prepare the SQL statement
    $sql = "UPDATE users 
            SET reset_token_hash = ?, 
                reset_token_expires_at = ?
            WHERE email = ?";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    $stmt->execute();
    // Execute the statement
    /* if ($stmt->execute()) {
        echo "Password reset token has been sent successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
 */
    // Close the statement
   /*  $stmt->close();
} else {
    echo "Email is not set in the POST data.";
}
 */

 if ($conn->affected_rows)
 {
  require 'mailer.php';

    //send to noreply@yourdomainname
  $mail->setFrom("tobestic53@gmail.com");
  //it will send to the add the user as supply
  $mail->addAddress($email);
  //set email subject
  $mail->Subject = "Password Reset";
  //set body
  $mail->Body = <<<END

  Click <a href="http://staff.ultimatelandmarkschools.org/reset-password.php?token=$token">here</a>
  to reset your password.
  END;

  //send the email using the send method
  try {
  $mail->send();

  } catch (Exception $e){
    echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
  }
 }

 echo "Message sent, please check your inbox.";
}