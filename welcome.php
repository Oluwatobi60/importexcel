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
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();


// Destroy session upon logout
/* if(isset($_GET['logout'])) {
  session_destroy();
  header("Location: index.php");
  exit;
} */
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
  <style>
    body {
      background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
      min-height: 100vh;
    }
    .navbar {
      border-radius: 0 0 1rem 1rem;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1.5px 4px rgba(0,0,0,0.04);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: translateY(-4px) scale(1.01);
      box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.08);
    }
    .form-label {
      font-weight: 500;
      color: #0d6efd;
    }
    .btn-success {
      background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
      border: none;
    }
    .btn-success:hover {
      background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
    }
    .btn-outline-light[title="Logout"]:hover {
      background: #fff;
      color: #0d6efd !important;
      border-color: #0d6efd;
      box-shadow: 0 2px 8px rgba(13,110,253,0.15);
    }
    .table {
      background: #fff;
      border-radius: 0.5rem;
      overflow: hidden;
    }
    .alert {
      border-radius: 0.75rem;
    }
    footer {
      margin-top: 3rem;
      background: linear-gradient(90deg, #e0eafc 0%, #cfdef3 100%);
      border-radius: 1rem 1rem 0 0;
      box-shadow: 0 -2px 12px rgba(0,0,0,0.04);
    }
    .footer-link {
      color: #0d6efd;
      text-decoration: none;
      font-weight: 500;
    }
    .footer-link:hover {
      text-decoration: underline;
      color: #185a9d;
    }
  </style>
  <script>
    function createYearOptions() {
      const currentYear = new Date().getFullYear();
      const yearSelect = document.getElementById('formDate');
      
      // Clear existing options except the first one
      while(yearSelect.options.length > 1) {
        yearSelect.remove(1);
      }

      // Add years from current year down to 2024 (or adjust as needed)
      for(let year = currentYear; year >= 2024; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
      }
    }
  </script>

</head>

<body onload="createYearOptions()">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
  <div class="container-fluid">
    <h3 class="navbar-brand">Welcome</h3>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <h4 class="text-white my-2"><i class="fas fa-user"></i> <?php echo is_array($row) && isset($row["fullnames"]) ? htmlspecialchars($row["fullnames"]) : "User"; ?></h4>
        </li>
      </ul>
  <a href="logout.php" class="btn btn-outline-light ms-2" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Check Your Salary Breakdown</h5>
        </div>
        <div class="card-body">
          <form class="row g-3" action="" method="post">
            <div class="col-md-6">
              <label for="smonth" class="form-label">Select Month</label>
              <select class="form-select" id="smonth" name="smonth" required>
                <option value="" selected>Select Month</option>
                <option value="January">January</option>
                <option value="February">February</option>
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
            <div class="col-md-6">
              <label for="formDate" class="form-label">Select Year</label>
              <select class="form-select" id="formDate" name="syear" required>
                <option value="" selected>Select Year</option>
              </select>
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-success px-4" name="sub">Display</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <?php
  // Process form submission
  if(isset($_POST["sub"])){
    $month = $_POST['smonth'];
    $year = $_POST['syear'];
    $email = (is_array($row) && isset($row["email"])) ? $row["email"] : null;
    echo '<div class="row justify-content-center">';
    if($email) {
      // Use PDO prepared statement for security
      $query = "SELECT * FROM tb_data WHERE `month` = ? AND `year` = ? AND `email` = ?";
      $stmt = $conn->prepare($query);
      $stmt->execute([$month, $year, $email]);
      $results = $stmt->fetchAll();
      $stmt->closeCursor();

      if($results && count($results) > 0){
        foreach($results as $result_row){
  ?>
    <div class="col-md-6 mb-4">
      <div class="card border-success shadow h-100">
        <div class="card-header bg-success text-white">Your Information</div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <tr><td><strong>Name</strong></td> <td><?php echo htmlspecialchars($result_row['fullnames']);?></td></tr>
            <tr><td><strong>Qualification</strong></td> <td><?php echo htmlspecialchars($result_row['qualification']);?></td></tr>
            <tr><td><strong>Designation</strong></td> <td><?php echo htmlspecialchars($result_row['designation']);?></td></tr>
            <tr><td><strong>Account No</strong></td> <td><?php echo htmlspecialchars($result_row['acct_no']);?></td></tr>
            <tr><td><strong>Bank</strong></td> <td><?php echo htmlspecialchars($result_row['bank']); ?></td></tr>
            <tr><td><strong>Total</strong></td> <td><?php echo htmlspecialchars($result_row['total']); ?></td></tr>
            <tr><td><strong>SOC</strong></td> <td><?php echo htmlspecialchars($result_row['soc']); ?></td></tr>
            <tr><td><strong>Tax</strong></td> <td><?php echo htmlspecialchars($result_row['tax']); ?></td></tr>
            <tr><td><strong>Month @ Hand</strong></td> <td><?php echo htmlspecialchars($result_row['month_hand']); ?></td></tr>
            <tr><td><strong>Late</strong></td> <td><?php echo htmlspecialchars($result_row['late']); ?></td></tr>
            <tr><td><strong>Absent</strong></td> <td><?php echo htmlspecialchars($result_row['absent_other']); ?></td></tr>
            <tr><td><strong>Loan</strong></td> <td><?php echo htmlspecialchars($result_row['loan']); ?></td></tr>
            <tr><td><strong>Food/Cooperative</strong></td><td> <?php echo htmlspecialchars($result_row['food_cooperative']); ?></td></tr>
            <tr><td><strong>Grand Balance</strong></td> <td><?php echo htmlspecialchars($result_row['grand_balance']); ?></td></tr>
            <tr><td><strong>Remarks</strong></td><td> <?php echo htmlspecialchars($result_row['remarks']); ?></td></tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="card border-info shadow h-100">
        <div class="card-header bg-info text-white">Note</div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <tr><td><strong>Acct_no</strong></td><td>ACCOUNT NUMBER</td></tr>
            <tr><td><strong>Month @ Hand</strong></td><td>MONTH @ HAND</td></tr>
            <tr><td><strong>Food/Cooperative</strong></td><td>FOOD/CO-OPERATIVE</td></tr>
            <tr><td><strong>Grand Balance</strong></td><td>GRAND BALANCE</td></tr>
          </table>
        </div>
      </div>
    </div>
  <?php
        }
      } else {
        echo "<div class='col-md-8 m-auto text-center alert alert-warning my-4' style='font-size:18px; font-weight:500'>No records found for $month $year!</div>";
      }
    } else {
      echo "<div class='col-md-8 m-auto text-center alert alert-danger my-4' style='font-size:18px; font-weight:500'>User email not found!</div>";
    }
    echo '</div>';
  }
  ?>
</div>

<footer class="bg-body-tertiary text-center">
  <!-- Grid container -->
  <div class="container p-4 pb-0">
    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Social media buttons (unchanged) -->
      <a class="btn text-white btn-floating m-1" style="background-color: #3b5998;" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
      <a class="btn text-white btn-floating m-1" style="background-color: #55acee;" href="#!" role="button"><i class="fab fa-twitter"></i></a>
      <a class="btn text-white btn-floating m-1" style="background-color: #dd4b39;" href="#!" role="button"><i class="fab fa-google"></i></a>
      <a class="btn text-white btn-floating m-1" style="background-color: #ac2bac;" href="#!" role="button"><i class="fab fa-instagram"></i></a>
      <a class="btn text-white btn-floating m-1" style="background-color: #0082ca;" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
      <a class="btn text-white btn-floating m-1" style="background-color: #333333;" href="#!" role="button"><i class="fab fa-github"></i></a>
    </section>
  </div>

  <div class="text-center p-3">
    <span style="font-size: 1.1rem;">&copy; <?php echo date('Y'); ?> <a class="footer-link" href="https://www.webportal.com">SALARY WEB PORTAL</a>. All rights reserved.</span>
  </div>
</footer>
</body>
</html>