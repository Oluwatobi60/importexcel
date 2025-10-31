<?php require 'config.php'; 
  if(!empty($_SESSION["id"])){
    header("Location: index.php");
  }
?>

<?php
if(isset($_POST['sub'])){

   
    $fullname = $_POST['fullname'];
     $email = $_POST['email'];
     $password = $_POST['password'];
      $cpass = $_POST['confirm_password'];
      $phone = $_POST['phone']; 
    /*   $add = $_POST['address']; */
   

   $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
   $stmt->execute([$email]);
   $count_email = $stmt->rowCount();

   if($count_email == 0){
     if($password == $cpass){
       $hash = password_hash($password, PASSWORD_DEFAULT);
       $stmt = $conn->prepare("INSERT INTO users (fullnames, email, pass, phone) VALUES (?, ?, ?, ?)");
       $stmt->execute([$fullname, $email, $hash, $phone]);
       echo "<script>alert('Registration Successful'); window.location='index.php';</script>";
     } else {
       echo "<script>alert('Password do not match!!!')</script>";
     }
   } else {
     echo "<script>alert('Email already exists!!!')</script>";
   }
      
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />

</head>
<body>

<!------------Main Container-------------->
  <div class="container d-flex justify-content-center align-items-center min-vh-100">

  <!-------------- Login Container-------------->
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
      <!-------------Left Box------------------>
      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
          <div class="featured-image mb-3">
            <img src="image/register.jpg" class="img-fluid" style="width: 250px;">
          </div>
          <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight:600;">Get Registered</p>
          <small class="text-white text-wrap text-center" style="width:17rem; font-family:'Courier New', Courier, monospace">Register to gain access into the system.</small>
      </div>

      <!----------Right BOx------------------->
      <div class="col-md-6 right-box">
            <div class="row align-items-center">
                  <div class="header-text mb-4">
                        <h2>Hello, </h2>
                        <p>We are happy to have you here</p>
                  </div>
                  <form action="" method="POST">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Full name here" name="fullname" required>
                  </div>

                  <div class="input-group mb-3">
                    <input type="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email here" name="email" required>
                  </div>

                     <!--  <div class="input-group mb-3">
                        <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password here" name="password" required>
                      </div>
 -->
                      <div class="input-group mb-3">
                    <input type="password" id="passwordField" class="form-control" placeholder="Password" name="password" required>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                       <!--  <i class="bi bi-eye-slash" id="eyeIcon"></i> -->
                       <i class="fas fa-eye-slash" id="eyeIcon"></i>
                      </button>
                    </div>
                  </div>


                  <div class="input-group mb-3">
                    <input type="password" id="passwordField1" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="togglePassword1">
                       <!--  <i class="bi bi-eye-slash" id="eyeIcon"></i> -->
                       <i class="fas fa-eye-slash" id="eyeIcon1"></i>
                      </button>
                    </div>
                  </div>

                     <!--  <div class="input-group mb-3">
                        <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Confirm Password here" name="confirm_password" required>
                      </div>
 -->
                     <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Phone Number here" name="phone">
                      </div> 

                     <!--  <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Address here" name="address">
                      </div> -->

                  <div class="input-group mb-3">
                    <button type="submit" class="btn btn-lg btn-primary w-100 fs-6" name="sub">Submit</button>
                  </div>
                  <div class="row">
                   <small>You already have an account? <a href="index.php">Login</a></small>
                  </div>
                  </form>
            </div>

            <script>

// Get references to the password field and the eye icon
var passwordField = document.getElementById("passwordField");
var eyeIcon = document.getElementById("eyeIcon");
var passwordField1 = document.getElementById("passwordField1");
var eyeIcon1 = document.getElementById("eyeIcon1");

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


document.getElementById("togglePassword1").addEventListener("click", function() {
if (passwordField1.type === "password") {
passwordField1.type = "text";
eyeIcon1.classList.remove("fa-eye-slash");
eyeIcon1.classList.add("fa-eye");
} else {
passwordField1.type = "password";
eyeIcon1.classList.remove("fa-eye");
eyeIcon1.classList.add("fa-eye-slash");
}
});

</script>
      </div>
    </div>
  </div>
</body>
</html>