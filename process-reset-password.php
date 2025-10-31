<?php
require 'config.php';

// Check if the required parameters are set
function showError($msg) {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Reset Password | Ultimate Landmark School</title>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">';
    echo '<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">';
    echo '<style>body{background:linear-gradient(135deg,#e0eafc 0%,#cfdef3 100%);min-height:100vh;font-family:Montserrat,sans-serif}.card{border-radius:1.25rem;box-shadow:0 4px 24px rgba(0,0,0,0.08),0 1.5px 4px rgba(0,0,0,0.04);margin-top:4rem}.school-logo{width:80px;height:80px;object-fit:contain;margin-bottom:1rem}.brand{color:#185a9d;font-weight:700;letter-spacing:1px;font-size:2rem}</style>';
    echo '</head><body><div class="container d-flex justify-content-center align-items-center min-vh-100"><div class="col-md-6"><div class="card p-4 text-center">';
    echo '<img src="image/uls-logo.png" alt="Ultimate Landmark School Logo" class="school-logo">';
    echo '<div class="brand mb-2">Ultimate Landmark School</div>';
    echo '<h4 class="mb-3">Reset Password</h4>';
    echo '<div class="alert alert-danger">' . htmlspecialchars($msg) . '</div>';
    echo '<a href="reset-password.php?token=' . htmlspecialchars($_POST["token"] ?? "") . '" class="btn btn-primary mt-2">Try Again</a>';
    echo '</div></div></div></body></html>';
    exit;
}

if (!isset($_POST["token"]) || !isset($_POST["password"]) || !isset($_POST["password_confirmation"])) {
    showError("Required parameters are missing!");
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
        showError("Token not found!");
    }
} catch (PDOException $e) {
    showError("An error occurred while executing the query.");
}

// Check if the token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    showError("Token has expired");
}

// Validate the new password
if (strlen($password) < 8) {
    showError("Password must be at least 8 characters");
}
if (!preg_match("/[a-z]/i", $password)) {
    showError("Password must contain at least one letter");
}
if (!preg_match("/[0-9]/", $password)) {
    showError("Password must contain at least one number");
}
if ($password !== $password_confirmation) {
    showError("Passwords must match");
}

// Hash the new password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $update_sql = "UPDATE users SET pass = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->execute([$password_hash, $user["id"]]);
    if ($update_stmt->rowCount()) {
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>Password Reset Success | Ultimate Landmark School</title>';
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">';
        echo '<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">';
        echo '<style>body{background:linear-gradient(135deg,#e0eafc 0%,#cfdef3 100%);min-height:100vh;font-family:Montserrat,sans-serif}.card{border-radius:1.25rem;box-shadow:0 4px 24px rgba(0,0,0,0.08),0 1.5px 4px rgba(0,0,0,0.04);margin-top:4rem}.school-logo{width:80px;height:80px;object-fit:contain;margin-bottom:1rem}.brand{color:#185a9d;font-weight:700;letter-spacing:1px;font-size:2rem}</style>';
        echo '<script>setTimeout(function(){window.location.href="index.php";}, 2500);</script>';
        echo '</head><body><div class="container d-flex justify-content-center align-items-center min-vh-100"><div class="col-md-6"><div class="card p-4 text-center">';
        echo '<img src="image/uls-logo.png" alt="Ultimate Landmark School Logo" class="school-logo">';
        echo '<div class="brand mb-2">Ultimate Landmark School</div>';
        echo '<h4 class="mb-3">Password Reset Successful</h4>';
        echo '<div class="alert alert-success">Your password has been updated. You can now login.</div>';
        echo '<a href="index.php" class="btn btn-primary mt-2">Go to Login</a>';
        echo '</div></div></div>';
        echo '<script>setTimeout(function(){alert("Password updated. You can now login."); window.location.href="index.php";}, 2000);</script>';
        echo '</body></html>';
    } else {
        showError("An error occurred while updating the password.");
    }
} catch (PDOException $e) {
    showError("An error occurred while updating the password.");
}
?>
