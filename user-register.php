<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit'])) {
    $name = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = md5($_POST['userPassword']);
    $phoneNumber = $_POST['userPhoneNumber'];

    $ret = mysqli_query($con, "SELECT userEmail FROM users WHERE userEmail='$email' ");
    $result = mysqli_fetch_array($ret);

    if($result > 0){
      $msg = "This email is already associated with another account.";
    }
    else{
	  //insert new user
      $query = mysqli_query($con, "INSERT INTO users(userName, userEmail, userPassword,  userPhoneNumber) value('$name', '$email', '$password', '$phoneNumber' )");

      if ($query) {
  		  $msg = "You have successfully registered!";
    		$sqlGetUserId = mysqli_query($con, "SELECT userID AS id FROM users WHERE userEmail='$email'");
    		$user = mysqli_fetch_assoc($sqlGetUserId);
    		$userID = $user['id'];
      }
      else {
        $msg="Something Went Wrong! Please try again";
      }
    }
}

// //prepare and bind
// $statement = $conn->prepare("INSERT INTO users(userName, userEmail, userPassword, userPhoneNumber)
//                               VALUES (?, ?, ?, ?)");
// $statement->bind_param("ssss", $name, $email, $password, $phoneNumber);
//
// //set parameters
// $name = $_POST['userName'];
// $email = $_POST['userEmail'];
// $password = md5($_POST['userPassword']);
// $phoneNumber = $_POST['userPhoneNumber'];
//
// //execute parameters
// $statement->execute();
//
// //close
// $statement->close();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ASport | Register</title>
  <?php
  include('includes/user-head-styles.php');
  ?>
	<script type="text/javascript">
    function checkpass() {
      if(document.register.userPassword.value!=document.register.userRepeatPassword.value) {
        alert('Password and Repeat Password fields do not match');
        document.register.userRepeatPassword.focus();
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
	<div class="row">
    <h1 align="center"><a href="index.php"><img src="images/ASport.png" width="130px"/></a></h1>
		<h1 align="center"><b><tt>ASport</tt></b></h1>
	  <br><br>
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading" style="text-align: center;">Register</div>
				<div class="panel-body">
					<form role="form" action="" method="post" id="" name="register" onsubmit="return checkpass();">
						<p style="font-size:16px; color:red" align="center"> <?php if($msg){
              echo $msg;
            }  ?> </p>
						<fieldset>
							<div class="form-group">
								<input type="text" class="form-control" name="userName" placeholder="Name" required="true">
							</div>
              <div class="form-group">
                <input type="text" class="form-control" name="userPhoneNumber" placeholder="Phone Number" maxlength="10" pattern="[0-9]{10}" required="true">
              </div>
							<div class="form-group">
								<input type="email" class="form-control" name="userEmail" placeholder="Email" required="true">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="userPassword" placeholder="Password" required="true">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="userRepeatPassword" placeholder="Repeat Password" required="true">
							</div>
							<div class="checkbox">
                <button type="submit" class="btn btn-primary" name="submit" value="submit" style="width: 100%;"><b>REGISTER</b></button><br><br>
                <p style="text-align: center;"><b>Already registered? <a href="user-login.php">Login Now</b></a></p>
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
