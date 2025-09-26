<?php require 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Import Excel o Mysql</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">


  <script>
    function createYearOptions(){
        var d = new Date();
        var currentYear = d.getFullYear();
        var currentMonth = d.getMonth() + 1;
        var yroptions = "<option value='0'>select year</option>";
    

    for (var i = currentYear; i < currentYear + 5; i++) {
      yroptions += "<option value="+i+">"+i+"</option>"
    }
    document.getElementById('formDate').innerHTML = yroptions;

  }
  </script>
</head>
<body onload="createYearOptions()">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center mt-5">
        <h1>Staff Salary Breakdown System</h1>
      </div>
    </div>

  <div class="row">

          <div class="col-sm-4 mb-2 mt-2">
          <form class="" action="" enctype="multipart/form-data" method="post">
              <input class="form-control form-control-lg mb-2" id="formFileLg" type="file" name="excel" required value="">
          </div>
              <div class="col-sm-4 mb-2 mt-2">
                <select class="form-select" aria-label="Default select example" name="smonth">
                    <option selected>Select Month</option>
                    <option value="January">January</option>
                    <option value="Febuary">Febuary</option>
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
                <div class="col-sm-4 mb-2 mt-2">
                    <select class="form-select" aria-label="Default select example" id="formDate" name="syear">
                          
                        
                      </select>
              </div>
        <div class="col-sm-4 mb-2 mt-2">
        <button type="submit" class="btn btn-success " name="import">Upload</button>
      </div>
</form>


            <div class="col-sm-4 mb-2 mt-2">
            <a href="export.php"><button type="submit" class="btn btn-primary" name="import11">Export To Excel</button></a>
            </div>
  </div>


  
  <div class="row mb-5">
  <table class="table table-dark table-hover text-center">
    <tr>
      <td>#</td>
      <td>Name</td>
      <td>Salary</td>
      <td>Month</td>
      <td>Year</td>
      <td>Email</td>
    </tr>

    <?php  
      $i = 1;
      $rows = mysqli_query($conn, "SELECT * FROM tb_data ");
      foreach($rows as $row):
    ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo $row["name"]?></td>
      <td><?php echo $row["salary"];?></td>
      <td><?php echo $row["month"]; ?></td>
      <td><?php echo $row["year"];?></td>
      <td><?php echo $row["email"]; ?></td>
    </tr>
    <?php endforeach; ?>
  </table>

  <?php
    if(isset($_POST["import"])){
      $fileName = $_FILES["excel"]["name"];
      $fileExtension = explode('.', $fileName);
      $fileExtension = strtolower(end($fileExtension));


      $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

      $targetDirectory = "uploads/" . $newFileName;
      move_uploaded_file($_FILES["excel"]["tmp_name"], $targetDirectory);

      error_reporting(0);
      ini_set('display_errors', 0);


      require "excelReader/excel_reader2.php";
      require "excelReader/SpreadsheetReader.php";


      $reader = new SpreadsheetReader($targetDirectory);
      foreach($reader as $key => $row){
        $name = $row[0];
        $salary = $row[1];
        $month = $row[2];
        $year = $row[3];
        $email = $row[4];
        mysqli_query($conn, "INSERT INTO tb_data VALUES('', '$name', '$salary', '$month', '$year', '$email')");
      }

      echo 
      " 
        <script>
        alert('Successfully Imported');
        document.location.href = '';
        </script>
      ";
    }

  ?>
  </div>
</body>
</html>