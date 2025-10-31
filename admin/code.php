<?php
session_start();
require 'config.php'; 

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


if(isset($_POST['save_excel_data'])){
  $fileName = $_FILES['import_file']['name'];
  $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

  //validation of extention file
  $allowed_ext = ['xls','csv','xlsx'];
 
  if(in_array($file_ext, $allowed_ext))
  {
    $inputFileNamePath = $_FILES['import_file']['tmp_name'];
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
    $data = $spreadsheet->getActiveSheet()->toArray();

    $count = "0";

    // Get the current year and month
    $currentYear = date('Y');
   /* $currentMonth = date('m'); */
    $msg = false; // Initialize message status

    foreach($data as $row)
    {
      if($count > 0)
      {
           /* $fullname = $row['0'];
            $qualification = $row['1'];
            $designation = $row['2'];
            $email = $row['3'];
            $acct_no = $row['4'];
            $bank = $row['5'];
            $total = $row['6'];
            $soc = $row['7'];
            $tax = $row['8'];
            $month_hand = $row['9'];
            $late = $row['10'];
            $absent_other = $row['11'];
            $loan = $row['12'];
            $food = $row['13'];
            $grand = $row['14'];
            $remarks = $row['15'];
            // Replace $month and $year with the current month and year
            $year = $currentYear;
          $month = $currentMonth; 
            $month = $row['17'];*/

// Initialize each variable with a default value to avoid null
            $fullname = isset($row[0]) ? $row[0] : ''; // Default to empty string if null
            $qualification = isset($row[1]) ? $row[1] : ''; // Default value
            $designation = isset($row[2]) ? $row[2] : '';
            $email = isset($row[3]) ? $row[3] : '';
            $acct_no = isset($row[4]) ? $row[4] : '';
            $bank = isset($row[5]) ? $row[5] : '';
            $total = isset($row[6]) ? $row[6] : '';
            $soc = isset($row[7]) ? $row[7] : '';
            $tax = isset($row[8]) ? $row[8] : '';
            $month_hand = isset($row[9]) ? $row[9] : '';
            $late = isset($row[10]) ? $row[10] : '';
            $absent_other = isset($row[11]) ? $row[11] : '';
            $loan = isset($row[12]) ? $row[12] : '';
            $food = isset($row[13]) ? $row[13] : '';
            $grand = isset($row[14]) ? $row[14] : '';
            $remarks = isset($row[15]) ? $row[15] : '';
            $year = isset($currentYear) ? $currentYear : date("Y"); // If year isn't set, use current year
            $month = isset($row[17]) ? $row[17] : date("m"); // Default to current month
            
            

      // Use prepared statements with PDO for security
      $sql_check = "SELECT COUNT(*) FROM tb_data WHERE month = ? AND fullnames = ?";
      $stmt_check = $conn->prepare($sql_check);
      $stmt_check->execute([$month, $fullname]);
      $exists = $stmt_check->fetchColumn();

      if($exists > 0){
        // If a record with the same name and month already exists, flag error and skip insertion
        $_SESSION['message'] = "Data is already exist";
        header('Location: index.php');
        exit(0);
      } else {
        $sql = "INSERT INTO tb_data (fullnames, qualification, designation, email, acct_no, bank, total, soc, tax, month_hand, late, absent_other, loan, food_cooperative, grand_balance, remarks, year, month) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
          $fullname, $qualification, $designation, $email, $acct_no, $bank, $total, $soc, $tax, $month_hand, $late, $absent_other, $loan, $food, $grand, $remarks, $year, $month
        ]);
        $msg = true;
      }
      }
          else{
            $count = "1";
          }
    }

    if(isset($msg))
    {
      $_SESSION['message'] = "Successfully Imported";
      header('Location: index.php');
      exit(0);
    }
    else
    {
      $_SESSION['message'] = "Not Imported";
      header('Location: index.php');
      exit(0);
    }
  }
  else{
    $_SESSION['message'] = "Invalid File";
    header('Location: index.php');
    exit(0);
  }
}


?>