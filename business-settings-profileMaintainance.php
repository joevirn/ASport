<!-- <?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the business id in the session is being cleared, log out the business
if (strlen($_SESSION['ASportBusinessSessionCounter'] == 0)) {
	header('location:business-logout.php');
}

else {
$businessID = $_SESSION['ASportBusinessSessionCounter'];

if(isset($_POST['submit'])) {
	$businessName = $_POST['businessName'];
	$businessEmail = $_POST['businessEmail'];
	$businessPhoneNumber = $_POST['businessPhoneNumber'];

	$query = mysqli_query($con, "
		UPDATE
			business
		SET
			businessName = '$businessName',
			businessEmail = '$businessEmail',
			businessPhoneNumber = '$businessPhoneNumber'
		WHERE
			businessID = '$businessID'
	");

	if ($query) {
		$msg = "Business profile has been updated!";
	}
	else {
		$msg = "Something Went Wrong. Please try again.";
	}
}
?> -->

	<!DOCTYPE html>
	<!--start of html-->
	<html>

	<!--start of head-->

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport for Business | Profile Maintainance</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
	  <?php define('PAGE', 'Profile Maintainance') ?>
		<?php include_once('includes/business-header.php');?>
		<?php include_once('includes/business-sidebar.php');?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
	        <li><a href="dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Settings -> Profile Maintainance</li>
				</ol>
			</div><!--/.row-->

	    <div class="row">
	      <div class="col-md-12">
	        <div class="panel panel-primary">
	          <div class="panel-heading">Profile Maintainance</div>
	        </div>
	      </div>
	    </div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<p style="font-size:16px; color:red" align="center">
	              <?php if($msg){ echo $msg;} ?>
	            </p>
							<div class="col-md-2"></div>
	            <div class="col-md-8">
	  					  <?php
	              $ret = mysqli_query($con,"SELECT * FROM business WHERE businessID='$businessID'");
	              while ($row = mysqli_fetch_array($ret)) {
	              ?>
	  							<form role="form" method="post" action="">
	  								<div class="form-group">
	  									<label><span class="fa fa-user"></span>&nbsp Business Name</label>
	  									<input class="form-control" type="text" value="<?php  echo $row['businessName'];?>" name="businessName" required="true">
	  								</div>
	  								<div class="form-group">
	  									<label><span class="fa fa-envelope"></span>&nbsp Email</label>
	                    <input class="form-control" type="email" name="businessEmail" value="<?php  echo $row['businessEmail'];?>" required="true">
	  								</div>
	  								<div class="form-group">
	  									<label><span class="fa fa-phone"></span>&nbsp Phone Number</label>
	  									<input class="form-control" type="text" name="businessPhoneNumber" value="<?php  echo $row['businessPhoneNumber'];?>" required="true" maxlength="10">
	  								</div>
	  								<div class="form-group">
	  									<label><span class="fa fa-calendar"></span>&nbsp Registration Date</label>
	  									<input class="form-control" type="text"  name="businessRegistrationDate" value="<?php  echo $row['businessRegistrationDate'];?>" readonly="true">
	  								</div>
	                  <br>
	                  <div align="center" class="form-group has-success">
	                    <button type="submit" class="btn btn-primary" name="submit" style="width: 50%;">UPDATE</button>
	                  </div>
	  							</form>
	  					  <?php } ?>
	            </div>
	            <div class="col-md-2"></div>
						</div>
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
	    <?php include_once('includes/footer.php');?>
		</div><!--/.main-->

	  <script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>
	<!--end of body-->

	</html>
	<!--end of html-->

<?php
}
?>
