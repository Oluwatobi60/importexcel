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
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token_hash = ?");
    $stmt->execute([$token_hash]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "Token not found!";
        exit;
    }
} catch (PDOException $e) {
    echo "An error occurred while executing the query.";
    exit;
}

// Check if the token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo "Token has expired";
    exit;
}

// Validate the new password
if (strlen($password) < 8) {
    echo "Password must be at least 8 characters";
    exit;
}
if (!preg_match("/[a-z]/i", $password)) {
    echo "Password must contain at least one letter";
    exit;
}
if (!preg_match("/[0-9]/", $password)) {
    echo "Password must contain at least one number";
    exit;
}
if ($password !== $password_confirmation) {
    echo "Passwords must match";
    exit;
}

// Hash the new password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $update_sql = "UPDATE users SET pass = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->execute([$password_hash, $user["id"]]);
    if ($update_stmt->rowCount()) {
        echo "Password updated. You can now login.";
    } else {
        echo "An error occurred while updating the password.";
    }
} catch (PDOException $e) {
    echo "An error occurred while updating the password.";
}
?>
