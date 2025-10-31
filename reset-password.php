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
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-4 m-auto">
                <h1>Reset Password</h1>
                
                <form method="POST" action="process-reset-password.php">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    
                      <div class="form-group">
                        <label for="exampleInputPassword1">New password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" aria-describedby="emailHelp" name="password">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Repeat password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirmation">
                      </div>
                      
                      <button type="submit" class="btn btn-primary">Submit</button>
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


