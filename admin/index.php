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
$result = mysqli_query($conn, "SELECT * FROM admin_table WHERE admin_id=$id");
$row = mysqli_fetch_assoc($result);

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"  />
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>


<!-- Navbar  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <h3 class="navbar-brand" >Welcome</h3>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <h4 class="text-white"><i class="fas fa-user"></i><?php echo $row["username"]; ?></h4>
            </li>
          </ul>
          <a href="../logout.php"><i class="fas fa-sign-out-alt fs-6"></i>Logout</a>
        </div>
      </div>
</nav>  <!-- end of navbar-->

<div class="container">
  <!--Begins of row for buttons-->
    <div class="row">
        <div class="col-sm-4 mb-2 mt-2">
                    <a href="export1.php"><button type="submit" class="btn btn-primary" name="import11">Export To Excel</button></a>
        </div>

        <div class="col-sm-4 mb-2 mt-2">
        <form method="post">
                    <!-- <a href="export_email.php" > --><button type="submit" class="btn btn-info" name="export" style="color:#fff;">Exract Staff Email</button><!-- </a> -->
                    </form>
        </div>
    </div><!-- end of row for buttton-->

    <!-- Extracting users email and name -->
<?php
// Step 2: Handle the form submission
if (isset($_POST['export'])) {
              // Select email addresses from the users table
              $sql = "SELECT * FROM users";
              $result = $conn->query($sql);

              // Step 3: Process the results
              if ($result->num_rows > 0) {
                  // Display email addresses
            ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">
                        <h2>Staff Email Addresses:</h2>
                      </div>
                      <div class="card-body">
                      <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                
                                <tr>
                                <th>S/N</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                              </tr>
            <?php
            $i=1;
                  while ($row = $result->fetch_assoc()) {
                    // Use isset to avoid undefined array keys
                    $fullnames = isset($row['fullnames']) ? $row['fullnames'] : 'Unknown';
                        $email = isset($row['email']) ? $row['email'] : 'No email provided';
            ?>
              <tr>
                <td><?php echo $i++ ; ?></td>
                <td><?php echo $fullnames;?></td> 
                <td><?php echo $email;?></td>  
              </tr>

            <?php
                    /*   echo "Email: " . $row["email"] . "<br>"; */
                  }
              } else {
                  echo "No emails found in the database.";
              }
} 

// Close the connection when done
$conn->close();
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


        <h1>Staff Salary Breakdown System</h1>
      </div>
</div>


<form class="" action="code.php" enctype="multipart/form-data" method="POST">
<input class="form-control form-control-lg mb-2" id="formFileLg" type="file" name="import_file" required value="">
<button type="submit" class="btn btn-success " name="save_excel_data">Upload</button>
</form>
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
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2024 Copyright:
    <a class="text-body" href="https://www.webportal.com">SALARY WEB PORTAL</a>
  </div>
  <!-- Copyright -->
</footer>

</body>
</html>