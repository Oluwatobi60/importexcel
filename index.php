<?php


require 'config.php'; 
session_start();

$remember = "";
if(isset($_POST["sub"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the login attempt is for a user
    $user_result = mysqli_query($conn, "SELECT * FROM users WHERE email='$username'") or die("Select error for users");
    $user_row = mysqli_fetch_assoc($user_result);

    if(mysqli_num_rows($user_result) > 0){
       // Verify the hashed password
          if(password_verify($password, $user_row["pass"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $user_row["id"];

              // Check if "Remember Me" checkbox is checked
              if(isset($_POST['remember'])){
                  // Set a cookie to remember the user's login status
                  setcookie("remember_user", $username, time() + (86400 * 30), '/'); // Set cookie for 30 days
                  setcookie("remember",$remember,time() + 86400 * 30);
              }
              else{
                setcookie("remember_user","", time() - 86400);
                setcookie("remember","", time() - 86400);
              }
            header("Location: welcome.php");
            exit();
        } else {
            echo "<script>alert('Wrong Password') </script>";
        }
    } else {
        // If user login fails, check if it's an admin login
        $admin_result = mysqli_query($conn, "SELECT * FROM admin_table WHERE username='$username'") or die("Select error for admins");
        $admin_row = mysqli_fetch_assoc($admin_result);

        if(mysqli_num_rows($admin_result) > 0){
            if($password == $admin_row["password"] ){
                $_SESSION["login"] = true;
                $_SESSION["admin_id"] = $admin_row["admin_id"];

                 // Check if "Remember Me" checkbox is checked
              if(isset($_POST['remember'])){
                // Set a cookie to remember the user's login status
                setcookie('remember_admin', $username, time() + (86400 * 30), '/'); // Set cookie for 30 days
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
</head>
<body>

<!------------Main Container-------------->
  <div class="container d-flex justify-content-center align-items-center min-vh-100">

  <!-------------- Login Container-------------->
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
      <!-------------Left Box------------------>
      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
          <div class="featured-image mb-3">
            <img src="image/login.png" class="img-fluid" style="width: 250px;">
          </div>
          <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight:600;">Be Verified</p>
          <small class="text-white text-wrap text-center" style="width:17rem; font-family:'Courier New', Courier, monospace">Login to check your salary breakdown.</small>
      </div>

      <!----------Right BOx------------------->
      <div class="col-md-6 right-box">
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