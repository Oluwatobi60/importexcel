<?php

/*$token = $_GET["token"];

$token_hash = hash("sha256", $token);


require 'config.php';

$sql = "SELECT * FROM users WHERE reset_token_hash = '$token_hash'";
$result = mysqli_query($conn, $sql);

if($result === null)
{
	echo ("Token not found!");
}

if (strtotime($result["reset_token_expires_at"]) <= time())
{
	echo "token has expired";
}
else{
	echo "token is valid and hasn't expired";

}*/

require 'config.php';

if (!isset($_GET["token"])) {
    echo "Token parameter is missing!";
    exit;
}

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token_hash = ?");
    $stmt->execute([$token_hash]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "Token not found!";
    } else {
        // Check if the token has expired
        if (strtotime($user["reset_token_expires_at"]) <= time()) {
            echo "Token has expired";
        } else {
            ?>
        
        <!DOCTYPE html>
<html lang="en">
                <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ultimate Landmark School | Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
            font-family: 'Montserrat', Arial, Helvetica, sans-serif;
        }
        .card {
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1.5px 4px rgba(0,0,0,0.04);
            margin-top: 4rem;
        }
        .school-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 1rem;
        }
        .brand {
            color: #185a9d;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 2rem;
        }
        .btn-primary {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            border: none;
            font-weight: 600;
            border-radius: 0.75rem;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
        }
        .form-label {
            color: #185a9d;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card p-4">
                <div class="text-center">
                    <img src="image/uls-logo.png" alt="Ultimate Landmark School Logo" class="school-logo">
                    <div class="brand mb-2">Ultimate Landmark School</div>
                    <h4 class="mb-4">Reset Password</h4>
                </div>
                <form method="POST" action="process-reset-password.php" autocomplete="off">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <div class="mb-3">
                        <label for="password" class="form-label">New password</label>
                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter new password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Repeat password</label>
                        <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="Repeat new password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

            <?php
        }
    }
} catch (PDOException $e) {
    echo "An error occurred while executing the query.";
}
?>


