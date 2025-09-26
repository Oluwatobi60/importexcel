<?php 

$conn = mysqli_connect("localhost", "root", "", "data"); 
  if($conn == false){
    die("Connection Error". mysqli_connect_error());
  }
?>