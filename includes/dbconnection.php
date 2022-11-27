<?php
$con=mysqli_connect("localhost", "root", "", "ASport");
if(mysqli_connect_errno()){
  echo "Connection Fail".mysqli_connect_error();
}
date_default_timezone_set('Asia/Kuala_Lumpur');
?>
