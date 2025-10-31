<?php 
session_start();  

require 'config.php'; 

// Check if user is logged in
if(empty($_SESSION["admin_id"])){
  // Redirect to login page if user is not logged in
  header("Location: ../index.php");
  exit;
} 


$id = $_SESSION["admin_id"];
$stmt = $conn->prepare("SELECT * FROM admin_table WHERE admin_id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

// Destroy session upon logout
if(isset($_GET['logout'])) {
  session_destroy();
  header("Location: ../index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Excel File</title>
</head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body, .navbar, .card, .table, .btn, .form-control, .form-select, .alert, footer {
      font-family: 'Montserrat', Arial, Helvetica, sans-serif !important;
    }
    h1, h2, h3, h4, h5, h6, .navbar-brand, .card-header {
      font-family: 'Montserrat', Arial, Helvetica, sans-serif !important;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
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
    .btn-primary, .btn-success, .btn-info {
      border-radius: 0.75rem;
      font-weight: 600;
      letter-spacing: 1px;
    }
    .btn-primary {
      background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
      border: none;
    }
    .btn-primary:hover {
      background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
    }
    .btn-success {
      background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
      border: none;
    }
    .btn-success:hover {
      background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
    }
    .btn-info {
      background: linear-gradient(90deg, #36d1c4 0%, #5b86e5 100%);
      border: none;
      color: #fff;
    }
    .btn-info:hover {
      background: linear-gradient(90deg, #5b86e5 0%, #36d1c4 100%);
      color: #fff;
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
</head>
<body>


<!-- Navbar  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
      <div class="container-fluid">
        <h3 class="navbar-brand" >Welcome</h3>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <h4 class="text-white"><i class="fas fa-user"></i><?php echo isset($row["username"]) ? $row["username"] : "Admin"; ?></h4>
            </li>
          </ul>
          <a href="../logout.php"><i class="fas fa-sign-out-alt fs-6"></i>Logout</a>
        </div>
      </div>
</nav>  <!-- end of navbar-->

<div class="container py-4">
  <!-- Action Buttons -->
  <div class="row justify-content-center align-items-center mb-4 g-3">
    <div class="col-md-4 col-12 mb-2 d-flex justify-content-center">
      <a href="export1.php" class="btn btn-primary w-100 py-3 fs-5">Export To Excel</a>
    </div>
    <div class="col-md-4 col-12 mb-2 d-flex justify-content-center">
      <form method="post" class="w-100">
        <button type="submit" class="btn btn-info w-100 py-3 fs-5" name="export">Extract Staff Email</button>
      </form>
    </div>
  </div>

    <!-- Extracting users email and name -->
<?php
// Step 2: Handle the form submission
if (isset($_POST['export'])) {
    // Select email addresses from the users table
    $sql = "SELECT * FROM users";
    $stmt = $conn->query($sql);
    $results = $stmt->fetchAll();

    // Step 3: Process the results
    if (count($results) > 0) {
        // Display email addresses
        ?>
        <div class="row justify-content-center mt-4 mb-5">
          <div class="col-lg-8">
            <div class="card border-info shadow mb-4">
              <div class="card-header bg-info text-white text-center">
                <h5 class="mb-0">Staff Email Addresses</h5>
              </div>
              <div class="card-body p-4">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                      <tr>
                        <th style="width: 10%;">S/N</th>
                        <th style="width: 45%;">Name</th>
                        <th style="width: 45%;">Email</th>
                      </tr>
                    </thead>
                    <tbody>
        <?php
        $i=1;
        foreach ($results as $row) {
            $fullnames = isset($row['fullnames']) ? $row['fullnames'] : 'Unknown';
            $email = isset($row['email']) ? $row['email'] : 'No email provided';
        ?>
          <tr>
            <td><?php echo $i++ ; ?></td>
            <td><?php echo $fullnames;?></td> 
            <td><?php echo $email;?></td>  
          </tr>

        <?php
        }
    } else {
        echo "No emails found in the database.";
    }
}
// No need to close PDO connection
?>

</table>
          </div>
                    </div>
         </div>
      </div>
    </div>
<!-- ending of extracting user email and name-->



<div class="row">
      <div class="col-sm-12 text-center mt-5">
        <?php

           /*  if(isset($_SESSION['message']))
            {
              echo "<script>alert('".$_SESSION['message']."')</script>";
            }
 */
        ?>

        <?php if (isset($_SESSION['message'])): ?>
          <script>
            alert("<?php echo $_SESSION['message']; ?>");
            <?php unset($_SESSION['message']); // Unset after use to avoid repetition ?>
          </script>
        <?php endif; ?>


  <!-- <h1 class="display-5 fw-bold mt-4 mb-3">Staff Salary Breakdown System</h1> -->
      </div>
</div>


<div class="row justify-content-center mt-4">
  <div class="col-lg-6">
    <div class="card shadow border-success">
      <div class="card-header bg-success text-white">Upload Excel File</div>
      <div class="card-body">
        <form action="code.php" enctype="multipart/form-data" method="POST">
          <input class="form-control form-control-lg mb-3" id="formFileLg" type="file" name="import_file" required>
          <button type="submit" class="btn btn-success w-100" name="save_excel_data">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div><!-- end of container -->

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
  <div class="text-center p-3">
    <span style="font-size: 1.1rem;">&copy; <?php echo date('Y'); ?> <a class="footer-link" href="https://www.webportal.com">SALARY WEB PORTAL</a>. All rights reserved.</span>
  </div>
  <!-- Copyright -->
</footer>

</body>
</html>