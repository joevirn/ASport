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
		$currentPassword = md5($_POST['currentPassword']);
		$newPassword = md5($_POST['newPassword']);
		$confirmPassword = md5($_POST['confirmPassword']);
		$query = mysqli_query($con,"SELECT userID FROM users WHERE userID='$userID' AND userPassword='$currentPassword'");
		$row = mysqli_fetch_array($query);
		if($row>0){
			if ($newPassword!=$currentPassword) {
				$ret = mysqli_query($con,"UPDATE users SET userPassword='$newPassword', userLastPasswordChangeDate=now() WHERE userID='$userID'");
				$msg = "Your password is successfully changed!";
				echo "<script>alert('$msg');</script>";
			}
			else {
				$msg = "Similar password detected! Please retry with a new password!";
				echo "<script>alert('$msg');</script>";
			}
		}
		else {
			$msg="Your current password is wrong!\nPlease try again.";
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
		<title>ASport | Change Password</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
		<script type="text/javascript">
			function checkpass() {
				if(document.changePassword.newPassword.value!=document.register.confirmPassword.value) {
					alert('New Password and Confirm Password fields do not match');
					document.changePassword.confirmPassword.focus();
					return false;
				}
				return true;
			}
		</script>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Change Password');
		include_once('includes/user-header.php');
		include_once('includes/user-sidebar.php');
		?>

		<!--start of division class 1-->
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<!--start of division class 2-->
			<div class="row">
				<!--start of ordered list-->
				<ol class="breadcrumb">
					<!--start of list-->
					<li><a href="user-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Settings -> Change Password</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Change Password</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-body">
	            <div class="col-md-2"></div>
							<div class="col-md-8">
							 <?php
	              $ret = mysqli_query($con,"SELECT * FROM users WHERE userID='$userID'");
	              while ($row = mysqli_fetch_array($ret)) {
									$userRegistrationDate = $row['userRegistrationDate'];
									$userLastPasswordChangeDate = $row['userLastPasswordChangeDate'];
	              ?>
								<br>
								<form role="form" method="post" action="" name="changePassword" onsubmit="return checkpass();">
									<div class="form-group">
										<label><span class="fa fa-key"></span>&nbsp Current Password</label>
										<input type="password" name="currentPassword" id="currentPassword" class=" form-control" required= "true" value="">
									</div>
									<div class="form-group">
										<label><span class="fa fa-lock"></span>&nbsp New Password</label>
										<input type="password" name="newPassword" id="newPassword" class="form-control" value="" required="true">
									</div>
									<div class="form-group">
										<label><span class="fa fa-check"></span>&nbsp Confirm Password</label>
										<input type="password" name="confirmPassword" id="confirmPassword" class="form-control" value="" required="true">
									</div>
	                <br>
	                <div align="center" class="form-group has-success">
	                  <button type="submit" class="btn btn-primary" name="submit" style="width: 50%;"><b>CHANGE</b></button>
	                </div>
	              </form>
								<?php } ?>
							</div>
	            <div class="col-md-2"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br>
							<h4><b>
								<span class="fa fa-pencil"></span>&nbsp Last Password Change Date:</b><br><br>
								<?php if ($userLastPasswordChangeDate): ?>
									<?php echo $userLastPasswordChangeDate; ?>
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

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

		<!--javascript source-->
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>
	<!--end of body-->

	</html>
	<!--end of html-->

<?php
}
?>
