<?php 

session_start();
require 'config.php';

// Check if user is logged in
if(empty($_SESSION["id"])){
  // Redirect to login page if user is not logged in
  header("Location: index.php");
  exit;
}


$id = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$row = mysqli_fetch_assoc($result);

// Destroy session upon logout
if(isset($_GET['logout'])) {
  session_destroy();
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  

</head>
<body onload="createYearOptions()">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <h3 class="navbar-brand" >Welcome</h3>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        <h4 class="text-white"><i class="fas fa-user"></i><?php echo $row["fullnames"]; ?></h4>
        </li>
      </ul>
       <a href="logout.php"><i class="fas fa-sign-out-alt fs-6"></i>Logout</a>
    </div>
  </div>
</nav>  



<!--- Display form for selecting month and year -->
<div class="container">
  <div class="row ">
    <div class="col-sm-4 mb-5 mt-5">
  <form class="" action="" enctype="multipart/form-data" method="post">
  <select class="form-select" aria-label="Default select example" name="smonth">
        <option selected>Select Month</option>
        <option value="January">January</option>
        <option value="Febuary">February</option>
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        <option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>
      </select>
  </div>
  <div class="col-sm-4 mb-5 mt-5">
   <select class="form-select" aria-label="Default select example" id="formDate" name="syear">
   <option selected>Select Year</option>
        <option value="2024">2024</option>   
    </select>
</div>
<div class="col-sm-4 mb-5 mt-5">
  <a href="export.php"><button type="submit" class="btn btn-info" name="sub">Display</button></a>
  </div>
  </form>
  </div>
  <?php
// Process form submission
if(isset($_POST["sub"])){
  $month = $_POST['smonth'];
  $year = $_POST['syear'];
  $email = $row["email"]; // Assuming $row["email"] is already defined elsewhere in your code
  // Assuming $conn is your database connection object

  // Sanitize input to prevent SQL injection
  $month = mysqli_real_escape_string($conn, $month);
  $year = mysqli_real_escape_string($conn, $year);
  $email = mysqli_real_escape_string($conn, $email);

   // Query to select data based on month, year, and email
   $query = "SELECT * FROM tb_data WHERE `month` = '$month' AND `year` = '$year' AND `email` = '$email'";
   $result = mysqli_query($conn, $query);

  // Check if query was successful
  if($result){

    if(mysqli_num_rows($result) > 0){
?>
<div class="row">
<?php
    // Loop through the results and display them
    while($row = mysqli_fetch_assoc($result)){
?>
       <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Your Information
                    </div>
                    <div class="card-body">
                    <table class="table table-dark table-hover">
                     
                    <tr><td>NAME:</td> <td><?php echo $row['fullnames'];?></td>  </tr>
                    <tr><td>QUALIFICAION:</td> <td><?php echo $row['qualification'];?></td></tr>
                    <tr><td>DESIGNATION:</td> <td><?php echo $row['designation'];?></td></tr>
                    <tr><td>ACCT_NO:</td> <td><?php echo $row['acct_no'];?></td></tr>
                    <tr><td>BANK:</td> <td><?php echo $row['bank']; ?></td></tr>
                    <tr><td>TOTAL:</td> <td><?php echo $row['total']; ?></td></tr>
                    <tr><td>SOC:</td> <td><?php echo $row['soc']; ?></td></tr>
                    <tr><td>TAX:</td> <td><?php echo $row['tax']; ?></td></tr>
                    <tr><td>M_HAND:</td> <td><?php echo $row['month_hand']; ?></td></tr>
                    <tr><td>LATE:</td> <td><?php echo $row['late']; ?></td></tr>
                    <tr><td>ABSENT:</td> <td><?php echo $row['absent_other'] ?></td></tr>
                    </tr><td>LOAN:</td> <td><?php echo $row['loan']; ?></td></tr>
                    <tr><td>F/C:</td><td> <?php echo $row['food_cooperative']; ?></td></tr>
                    <tr><td>G_B:</td> <td><?php echo $row['grand_balance']; ?></td></tr>
                    <tr><td>REMARKS:</td><td> <?php echo $row['remarks']; ?></td></tr>
                    
                    </table>
                    </div>
                </div>
            </div>

                 
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Note
                    </div>
                    <div class="card-body">
                    <table class="table table-dark table-hover">
                            <tr><td>Acct_no:</td><td>ACCOUNT NUMBER</td></tr>
                            <tr><td>M_Hand:</td><td>MONTH @ HAND</td></tr>
                            <tr><td>F/C:</td><td>FOOD/CO-OPERATIVE</td></tr>
                            <tr><td>G_B:</td><td>GRAND BALANCE</td></tr>
                    </table>
                    </div>
                </div>
            </div>
<?php
    }
?>
   <!--  </table>
  </div> -->
</div>
<?php
  } else {
    echo "<div class='row'>
          <div class='col-md-6 m-auto text-center bg-warning' style='color:red; font-size:20px; font-weight:500'>
          No records found for this month!!.
          </div>
          </div>";
  }


  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>

       
</div>
<footer class="bg-body-tertiary text-center">
  <!-- Grid container -->
  <div class="container p-4 pb-0">
    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Facebook -->
      <a
      data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #3b5998;"
        href="#!"
        role="button"
        ><i class="fab fa-facebook-f"></i
      ></a>

      <!-- Twitter -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #55acee;"
        href="#!"
        role="button"
        ><i class="fab fa-twitter"></i
      ></a>

      <!-- Google -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #dd4b39;"
        href="#!"
        role="button"
        ><i class="fab fa-google"></i
      ></a>

      <!-- Instagram -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #ac2bac;"
        href="#!"
        role="button"
        ><i class="fab fa-instagram"></i
      ></a>

      <!-- Linkedin -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #0082ca;"
        href="#!"
        role="button"
        ><i class="fab fa-linkedin-in"></i
      ></a>
      <!-- Github -->
      <a
        data-mdb-ripple-init
        class="btn text-white btn-floating m-1"
        style="background-color: #333333;"
        href="#!"
        role="button"
        ><i class="fab fa-github"></i
      ></a>
    </section>
    <!-- Section: Social media -->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2024 Copyright:
    <a class="text-body" href="https://www.webportal.com">SALARY WEB PORTAL</a>
  </div>
  <!-- Copyright -->
</footer>


   
</body>
</html>