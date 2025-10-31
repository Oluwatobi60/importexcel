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

$stmt = $conn->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($results && count($results) > 0) {
    foreach ($results as $row) {
        $rowdata = array(
            $row['fullnames'],
            $row['qualification'],
            $row['designation'],
            $row['email'],
            $row['acct_no'],
            $row['bank'],
            $row['total'],
            $row['soc'],
            $row['tax'],
            $row['month_hand'],
            $row['late'],
            $row['absent_other'],
            $row['loan'],
            $row['food_cooperative'],
            $row['grand_balance'],
            $row['remarks'],
            $row['year'],
            $row['month']
        );
        array_walk($rowdata, 'filterData');
        $excelData .= implode("\t", array_values($rowdata)) . "\n";
    }
} else {
    $excelData .= 'No records found...' . "\n";
}

//Header for download

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename =\"$fileName\"");

//Render excel data
echo $excelData;

exit;

