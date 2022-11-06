<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit'])) {
    $name = $_POST['businessName'];
    $email = $_POST['businessEmail'];
    $password = md5($_POST['businessPassword']);
    $phoneNumber = $_POST['businessPhoneNumber'];

    $ret = mysqli_query($con, "SELECT businessEmail FROM business WHERE businessEmail='$email' ");
    $result = mysqli_fetch_array($ret);

    if($result > 0){
      $msg = "This email is already associated with another account.";
    }
    else{
	     //insert new business
      $query = mysqli_query($con, "INSERT INTO business(businessName, businessEmail, businessPassword,  businessPhoneNumber) value('$name', '$email', '$password', '$phoneNumber')");
      if ($query) {
    		$msg = "You have successfully registered!";
        echo "<script>alert('$msg');</script>";
    		$sqlGetbusinessId = mysqli_query($con, "SELECT businessID AS id FROM business WHERE businessEmail='$email'");
    		$business = mysqli_fetch_assoc($sqlGetbusinessId);
    		$businessID = $business['id'];

        $queryAddVenueManagement = mysqli_query($con, "INSERT INTO businessVenueManagement(businessID, businessPhoneNumber,  businessEmail, timeStampLastEditContactUs) value('$businessID', '$phoneNumber', '$email', now())");
        if ($queryAddVenueManagement) {
          $msg = "Business Phone Number and Email have been copied to the Contact Us page!";
          echo "<script>alert('$msg');</script>";
        }
        else {
          $msg = "Error copying business phone number and email to the Contact Us page!";
          echo "<script>alert('$msg');</script>";
        }

        echo "<script>window.location.href='business-login.php'</script>";
      }
      else {
        $msg="Something Went Wrong! Please try again";
        echo "<script>alert('$msg');</script>";
      }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ASport for Business | Register</title>
  <?php
  include('includes/business-head-styles.php');
  ?>
	<script type="text/javascript">
    function checkpass() {
      if(document.register.businessPassword.value!=document.register.businessRepeatPassword.value) {
        alert('Password and Repeat Password fields do not match');
        document.register.businessRepeatPassword.focus();
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
	<div class="row">
    <h1 align="center"><a href="index.php"><img src="images/ASport.png" width="130px"/></a></h1>
		<h1 align="center"><b><tt>ASport for Business</tt></b></h1>
	  <br><br>
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading" style="text-align: center;">Register</div>
				<div class="panel-body">
					<form role="form" action="" method="post" id="" name="register" onsubmit="return checkpass();">
						<fieldset>
							<div class="form-group">
								<input type="text" class="form-control" name="businessName" placeholder="Business Name" required="true">
							</div>
              <div class="form-group">
                <input type="text" class="form-control" name="businessPhoneNumber" placeholder="Phone Number" maxlength="10" pattern="[0-9]{10}" required="true">
              </div>
							<div class="form-group">
								<input type="email" class="form-control" name="businessEmail" placeholder="Email" required="true">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="businessPassword" placeholder="Password" required="true">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="businessRepeatPassword" placeholder="Repeat Password" required="true">
							</div>
							<div class="checkbox">
                <button type="submit" class="btn btn-primary" name="submit" value="submit" style="width: 100%;"><b>REGISTER</b></button><br><br>
                <p style="text-align: center;"><b>Already registered? <a href="business-login.php">Login Now</b></a></p>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
  <br>  

  <!--include the footer-->
  <?php include_once('includes/footer.php'); ?>

  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
