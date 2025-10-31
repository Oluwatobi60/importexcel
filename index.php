<?php
require 'config.php'; 
session_start();

$remember = "";
if(isset($_POST["sub"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the login attempt is for a user
  // User login with PDO
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$username]);
  $user_row = $stmt->fetch(PDO::FETCH_ASSOC);

  if($user_row){
    // Verify the hashed password
    if(password_verify($password, $user_row["pass"])) {
      $_SESSION["login"] = true;
      $_SESSION["id"] = $user_row["id"];

      // Check if "Remember Me" checkbox is checked
      if(isset($_POST['remember'])){
        setcookie("remember_user", $username, time() + (86400 * 30), '/');
        setcookie("remember", $remember, time() + 86400 * 30);
      } else {
        setcookie("remember_user", "", time() - 86400);
        setcookie("remember", "", time() - 86400);
      }
      header("Location: welcome.php");
      exit();
    } else {
      echo "<script>alert('Wrong Password') </script>";
    }
  } else {
    // Admin login with PDO
    $stmt = $conn->prepare("SELECT * FROM admin_table WHERE username = ?");
    $stmt->execute([$username]);
    $admin_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($admin_row){
      if($password == $admin_row["password"] ){
        $_SESSION["login"] = true;
        $_SESSION["admin_id"] = $admin_row["admin_id"];

        if(isset($_POST['remember'])){
          setcookie('remember_admin', $username, time() + (86400 * 30), '/');
        }
        header("Location: admin/index.php");
        exit();
      } else {
        echo "<script>alert('Wrong Password') </script>";
      }
    } else {
      echo "<script>alert('User Not Registered') </script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index::Login page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="style1.css">
  <style>
    body {
      background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
      min-height: 100vh;
    }
    .box-area {
      border-radius: 1.5rem;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1.5px 4px rgba(0,0,0,0.04);
      background: #fff;
      overflow: hidden;
    }
    .left-box {
      background: linear-gradient(135deg, #185a9d 0%, #43cea2 100%);
      color: #fff;
      border-radius: 1.5rem 0 0 1.5rem;
      min-height: 400px;
    }
    .left-box .featured-image img {
      max-width: 220px;
      border-radius: 1rem;
      box-shadow: 0 2px 12px rgba(0,0,0,0.10);
    }
    .right-box {
      border-radius: 0 1.5rem 1.5rem 0;
      min-height: 400px;
      background: #f8f9fa;
    }
    .header-text h2 {
      font-weight: 700;
      color: #185a9d;
    }
    .header-text p {
      color: #555;
    }
    .form-control, .form-select {
      border-radius: 0.75rem;
      font-size: 1rem;
    }
    .btn-primary {
      background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
      border: none;
      font-weight: 600;
      letter-spacing: 1px;
      border-radius: 0.75rem;
    }
    .btn-primary:hover {
      background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
    }
    .forgot a {
      color: #185a9d;
      text-decoration: none;
      font-weight: 500;
    }
    .forgot a:hover {
      text-decoration: underline;
    }
    .row .form-check-label {
      color: #555;
    }
    .row small a {
      color: #43cea2;
      font-weight: 600;
    }
    .row small a:hover {
      color: #185a9d;
      text-decoration: underline;
    }
    @media (max-width: 767px) {
      .left-box, .right-box {
        border-radius: 1.5rem !important;
      }
      .box-area {
        border-radius: 1.5rem !important;
      }
    }
  </style>
</head>
<body>

<!------------Main Container-------------->
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <?php
      if (isset($_SESSION['reset_message'])) {
        $resetMsg = $_SESSION['reset_message'];
        unset($_SESSION['reset_message']);
        echo "<script>alert('" . addslashes($resetMsg) . "');</script>";
      }
    ?>

  <!-------------- Login Container-------------->
  <div class="row box-area p-0">
      <!-------------Left Box------------------>
  <div class="col-md-6 d-flex justify-content-center align-items-center flex-column left-box p-4">
          <div class="featured-image mb-3">
            <img src="image/login.png" class="img-fluid" alt="Login Illustration">
          </div>
          <p class="fs-2 fw-bold mb-2" style="font-family: 'Montserrat', sans-serif;">Be Verified</p>
          <small class="text-white text-wrap text-center mb-2" style="width:17rem; font-family:'Montserrat', sans-serif;">Login to check your salary breakdown.</small>
      </div>

      <!----------Right BOx------------------->
  <div class="col-md-6 right-box p-4">
            <div class="row align-items-center">
                  <div class="header-text mb-4">
                        <h2>Hello, Again</h2>
                        <p>We are happy to have you back</p>
                  </div>
                  <form action="" method="POST">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Email/username" name="username" required>
                  </div>

                <!--   <div class="input-group mb-3">
                    <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password here" name="password" required>
                  </div> -->

                  <div class="input-group mb-3">
                    <input type="password" id="passwordField" class="form-control" placeholder="Password" name="password" required>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                       <!--  <i class="bi bi-eye-slash" id="eyeIcon"></i> -->
                       <i class="fas fa-eye-slash" id="eyeIcon"></i>
                      </button>
                    </div>
                  </div>

                  <div class="input-group mb-5 d-flex justify-content-between">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="formCheck" name="remember" <?php if(!empty($remember)) { ?> checked <?php } elseif(isset($_COOKIE["remember"])){ ?> checked <?php } ?>>
                        <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                      </div>
                          <div class="forgot">
                            <small><a href="forgot-password.php">Forgot Password?</a></small>
                          </div>
                  </div>
                  <div class="input-group mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6" name="sub">Login</button>
                  </div>
                  <div class="row">
                   <small>Don't have account? <a href="user.php">Sign Up</a></small>
                  </div>
                  </form>
            </div>

            <script>

            // Get references to the password field and the eye icon
var passwordField = document.getElementById("passwordField");
var eyeIcon = document.getElementById("eyeIcon");

// Add event listener to toggle password visibility
document.getElementById("togglePassword").addEventListener("click", function() {
  if (passwordField.type === "password") {
    passwordField.type = "text";
    eyeIcon.classList.remove("fa-eye-slash");
    eyeIcon.classList.add("fa-eye");
  } else {
    passwordField.type = "password";
    eyeIcon.classList.remove("fa-eye");
    eyeIcon.classList.add("fa-eye-slash");
  }
});

</script>
      </div>
    </div>
  </div>
</body>
</html>