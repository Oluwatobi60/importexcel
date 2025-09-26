<?php

require 'config.php'; 


// Filter the excel data
function filterData(&$str){
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

//Excel file name for download
$fileName = "staff_salary_excel_format-" . date('Ymd') . ".xls";

//column names
$fields = array('FULLNAMES', 'QUALIFICATION', 'DESIGNATION', 'EMAIL', 'ACCT NO', 'BANK', 'TOTAL', 'SOC', 'TAX', 'MONTH_HAND', 'LATE', 'ABSENT', 'LOAN', 'FOOD_COOPERATIVE', 'GRAND_BALANCE', 'REMARKS', 'YEAR', 'MONTH');

//Display column names as first row
$excelData = implode("\t", array_values($fields)) . "\n";

//Get records from the database
$query = "SELECT * FROM tb_data";
$result_check = mysqli_query($conn,$query);

/* if($result_check > 0){
  //output each row of the data

  while($row = $result_check->fetch_assoc()){
    $rowdata = array($row['FULLNAMES'], $row['QUALIFICATION'], $row['DESIGNATION'], $row['EMAIL'], $row['ACCT NO'], $row['BANK'], $row['TOTAL'], $row['SOC'], $row['TAX'], $row['MONTH_HAND'], $row['LATE'], $row['ABSENT'], $row['LOAN'], $row['FOOD_COOPERATIVE'], $row['GRAND_BALANCE'], $row['REMARKS'], $row['YEAR'], $row['MONTH']);
    array_walk($rowdata, 'filterData');
    $excelData .= implode("\t", array_values($rowdata)) . "\n";
  }
}else{
  $excelData .= 'No records found...'. "\n";
} */

//Header for download

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename =\"$fileName\"");

//Render excel data
echo $excelData;

exit;

