<?php
require 'config.php';

// Check if the required parameters are set
if (!isset($_POST["token"]) || !isset($_POST["password"]) || !isset($_POST["password_confirmation"])) {
    echo "Required parameters are missing!";
    exit;
}

$token = $_POST["token"];
$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

$token_hash = hash("sha256", $token);

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE reset_token_hash = ?");
$stmt->bind_param("s", $token_hash);

$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    echo "An error occurred while executing the query.";
    exit;
}

// Check if the token exists in the database
if ($result->num_rows === 0) {
    echo "Token not found!";
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();

// Check if the token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo "Token has expired";
    $stmt->close();
    $conn->close();
    exit;
}

// Validate the new password
if (strlen($password) < 8) {
    echo "Password must be at least 8 characters";
    $stmt->close();
    $conn->close();
    exit;
}

if (!preg_match("/[a-z]/i", $password)) {
    echo "Password must contain at least one letter";
    $stmt->close();
    $conn->close();
    exit;
}

if (!preg_match("/[0-9]/", $password)) {
    echo "Password must contain at least one number";
    $stmt->close();
    $conn->close();
    exit;
}

if ($password !== $password_confirmation) {
    echo "Passwords must match";
    $stmt->close();
    $conn->close();
    exit;
}

// Hash the new password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Update the user's password and reset token fields
$update_sql = "UPDATE users 
               SET pass = ?, 
               reset_token_hash = NULL, 
               reset_token_expires_at = NULL 
               WHERE id = ?";
        
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("si", $password_hash, $user["id"]); // Correct binding type for integer
$update_stmt->execute();

if ($update_stmt->errno) {
    echo "An error occurred while updating the password.";
} else {
    echo "Password updated. You can now login.";
}

$stmt->close();
$update_stmt->close();
$conn->close();
?>
