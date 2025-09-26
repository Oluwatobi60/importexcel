<?php

require 'config.php'; 

if(isset($_POST['export_email'])){

  $query = "SELECT * FROM users";
   $result = mysqli_query($conn, $query);
?>
   <div class="row">
<?php
    // Loop through the results and display them
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
?>
       <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        STAFF EMAIL ADDRESS
                    </div>
                    <div class="card-body">
                    <table class="table table-dark table-hover">
                     
                    <tr><td>S/N</td> <td><?php echo $i++?></td>  </tr>
                    <tr><td>NAME:</td> <td><?php echo $row['fullnames'];?></td>  </tr>
                    <tr><td>EMAIL:</td> <td><?php echo $row['email'];?></td></tr>
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
}

?>