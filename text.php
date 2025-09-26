<?php
if (class_exists('ZipArchive')) {
    echo "ZipArchive class is available.";
} else {
    echo "ZipArchive class is not available.";
}
?>




 <!--  <script>
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
  </script> -->



  // Check if user is logged in
if(!empty($_SESSION["id"])){
  $id = $_SESSION["id"];
  $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
  $row = mysqli_fetch_assoc($result);
} else {
  // Redirect to login page if user is not logged in
  header("Location: index.php");
}