<?php require 'config.php'; 
  if(!empty($_SESSION["id"])){
    header("Location: index.php");
  }
?>

<?php
if(isset($_POST['sub'])){

   
    $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
     $email = $_POST['email'];
     $password = $_POST['password'];
      $cpass = $_POST['confirm_password'];
      $phone = $_POST['phone'];
      $add = $_POST['address'];
   

   $sql = "select * from users where email='$email'";
   $result = mysqli_query($conn, $sql);
   $count_email = mysqli_num_rows($result);

   if($count_email==0){
    if($password==$cpass){
       /*  $hash = password_hash($password, PASSWORD_DEFAULT); */
        $sql = "insert into users(firstname, lastname, email, pass, phone, addr) values('$firstname', '$lastname', '$email', '$password', '$phone', '$add')";
        $result = mysqli_query($conn, $sql);

        echo "<script>alert('Registration Successful')</script>";
    }else{
      echo "<script>alert('Password do not match!!!')</script>";
    }
      
   }
   else{
    echo "<script>alert('Email already exists!!!')</script>";
   }
      
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container-fluid bg-dark text-light py-3">
    <header class="text-center">
      <h2 class="display-6">WELCOME TO STAFF SALARY SYSTEM</h2>
    </header>
</div>
<section class="container-fluid my-2 bg-dark w-50 text-light p-2">
<form class="row g-3 p-3" action="" method="POSt">

  <div class="col-md-6">
    <label for="validationCustom01" class="form-label">First name</label>
    <input type="text" class="form-control" id="validationCustom01" placeholder="Enter your first name" name="firstname" required>
  </div>
  <div class="col-md-6">
    <label for="validationCustom02" class="form-label">Last name</label>
    <input type="text" class="form-control" id="validationCustom02" placeholder="Enyer your last name" name="lastname" required>
  </div>
        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Email</label>
          <input type="email" class="form-control" id="inputEmail4" placeholder="Enter your email" name="email">
        </div>
        <div class="col-md-6">
          <label for="inputPassword4" class="form-label">Password</label>
          <input type="password" class="form-control" id="inputPassword4" name="password">
        </div>
        <div class="col-md-6">
          <label for="inputCity" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="inputCity" name="confirm_password">
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label">Phone No.</label>
          <input type="number" class="form-control" id="inputCity" placeholder="your phone number here" name="phone">
        </div> 

        <div class="col-12">
          <label for="inputAddress" class="form-label">Address</label>
          <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address">
        </div>
       
        
        <div class="col-12">
            <span>If you're already have account an <a href="login.php">Login here</a></span>
        </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary" name="sub">Submit</button>
        </div>
</form>
</section>
</body>
</html>