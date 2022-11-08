<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login']))
  {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $query = mysqli_query($con,"SELECT userID FROM users WHERE userEmail='$email' AND userPassword='$password' ");
    $ret = mysqli_fetch_array($query);

    if($ret>0){
      $_SESSION['ASportUserSessionCounter'] = $ret['userID'];
      header('location:user-dashboard.php');
    }
    else{
      $msg="Invalid Credentials.";
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ASport | Login</title>
  <?php
  include('includes/user-head-styles.php');
  ?>
</head>
<body>

	<div class="row">
    <h1 align="center"><a href="index.php"><img src="images/ASport.png" width="130px"/></a></h1>
		<h1 align="center"><b><tt>ASport</tt></b></h1>
	  <br><br>
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading" style="text-align: center;">Log In</div>
				<div class="panel-body">
					<p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
					<form role="form" action="" method="post" id="" name="login">
						<fieldset>
						<div class="form-group">
              <input class="form-control" placeholder="Email" name="email" type="email" autofocus="" required="true">
						</div>
						<div class="form-group">
              <input class="form-control" placeholder="Password" name="password" type="password" value="" required="true">
						</div>
						<div class="checkbox">
  						<button type="submit" value="login" name="login" class="btn btn-primary" style="width: 100%;"><b>LOGIN</b></button><br><br>
  						<p style="text-align: center;"><b>Not registered? <a href="user-register.php">Register Now</b></a></p>
              <!-- <p align="center"><a href="mailto:forgetpassword@asport.com">Forget Password</a></p> -->
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
