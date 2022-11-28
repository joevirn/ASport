<?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the user id in the session is being cleared, log out the user
if (strlen($_SESSION['ASportUserSessionCounter'] == 0)) {
	header('location:user-logout.php');
}

else {
$userID = $_SESSION['ASportUserSessionCounter'];

if(isset($_POST['submit'])) {
	$userName = $_POST['userName'];
	$userEmail = $_POST['userEmail'];
	$userPhoneNumber = $_POST['userPhoneNumber'];

	$query = mysqli_query($con, "
		UPDATE
			users
		SET
			userName = '$userName',
			userEmail = '$userEmail',
			userPhoneNumber = '$userPhoneNumber',
			userLastUpdateDate = now()
		WHERE
			userID = '$userID'
	");

	if ($query) {
		$msg = "User profile has been updated!";
		echo "<script>alert('$msg');</script>";
	}
	else {
		$msg = "Something Went Wrong. Please try again.";
		echo "<script>alert('$msg');</script>";
	}
}
?>

	<!DOCTYPE html>
	<!--start of html-->
	<html>

	<!--start of head-->

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport | Profile Maintenance</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
	  <?php define('PAGE', 'Profile Maintenance') ?>
		<?php include_once('includes/user-header.php');?>
		<?php include_once('includes/user-sidebar.php');?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
	        <li><a href="user-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Settings -> Profile Maintenance</li>
				</ol>
			</div><!--/.row-->

	    <div class="row">
	      <div class="col-md-12">
	        <div class="panel panel-primary">
	          <div class="panel-heading">Profile Maintenance</div>
	        </div>
	      </div>
	    </div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-body"><br>
							<div class="col-md-2"></div>
	            <div class="col-md-8">
	  					  <?php
	              $ret = mysqli_query($con,"SELECT * FROM users WHERE userID='$userID'");
	              while ($row = mysqli_fetch_array($ret)) {
									$userRegistrationDate = $row['userRegistrationDate'];
									$userLastUpdateDate = $row['userLastUpdateDate'];
	              ?>
	  							<form role="form" method="post" action="">
	  								<div class="form-group">
	  									<label><span class="fa fa-user"></span>&nbsp Name</label>
	  									<input class="form-control" type="text" value="<?php  echo $row['userName'];?>" name="userName" required="true">
	  								</div>
	  								<div class="form-group">
	  									<label><span class="fa fa-envelope"></span>&nbsp Email</label>
	                    <input class="form-control" type="email" name="userEmail" value="<?php  echo $row['userEmail'];?>" required="true">
	  								</div>
	  								<div class="form-group">
	  									<label><span class="fa fa-phone"></span>&nbsp Phone Number</label>
	  									<input class="form-control" type="text" name="userPhoneNumber" value="<?php  echo $row['userPhoneNumber'];?>" required="true" maxlength="10">
	  								</div>
	                  <br>
	                  <div align="center" class="form-group has-success">
	                    <button type="submit" class="btn btn-primary" name="submit" style="width: 50%;"><b>UPDATE</b></button>
	                  </div>
	  							</form>
	  					  <?php } ?>
	            </div>
	            <div class="col-md-2"></div>
						</div>
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br>
							<h4><b>
								<span class="fa fa-pencil"></span>&nbsp Last Update Date:</b><br><br>
								<?php if ($userLastUpdateDate): ?>
									<?php echo $userLastUpdateDate; ?>
								<?php else: ?>
									No Updates Recorded
								<?php endif; ?>
							</h4><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><h4><b><span class="fa fa-file-o"></span>&nbsp Registration Date:</b><br><br><?php echo $userRegistrationDate; ?></h4><br>
						</div><!-- /.panel-body-->
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
