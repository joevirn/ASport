<?php
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

	$ret = mysqli_query($con,"SELECT * FROM businessVenueManagement WHERE businessID='$businessID'");
	while ($row = mysqli_fetch_assoc($ret)) {
		$businessVenueManagementID = $row['businessVenueManagementID'];
		$current_businessPhoneNumber = $row['businessPhoneNumber'];
		$current_businessEmail = $row['businessEmail'];
		$current_facebookLink = $row['facebookLink'];
		$current_twitterLink = $row['twitterLink'];
		$current_instagramLink = $row['instagramLink'];
		$current_youtubeLink = $row['youtubeLink'];
		$timeStampLastEditContactUs = $row['timeStampLastEditContactUs'];
	}

	if(isset($_POST['submit']))
	{
		$businessPhoneNumber = $_POST['businessPhoneNumber'];
		$businessEmail = $_POST['businessEmail'];
		$facebookLink = $_POST['facebookLink'];
		$twitterLink = $_POST['twitterLink'];
		$instagramLink = $_POST['instagramLink'];
		$youtubeLink = $_POST['youtubeLink'];

		//ADD FORM FIELDS TO DATABASE
	  $sqlUpdate = mysqli_query($con,
	    "UPDATE
				businessVenueManagement
			SET
				businessPhoneNumber = '$businessPhoneNumber',
				businessEmail = '$businessEmail',
				facebookLink = '$facebookLink',
				twitterLink = '$twitterLink',
				instagramLink = '$instagramLink',
				youtubeLink = '$youtubeLink',
				timeStampLastEditContactUs = now()
			WHERE
				businessVenueManagementID = '$businessVenueManagementID'
				AND
				businessID = '$businessID'
			");

		//JAVASCRIPT ALERT STATUS
		//Record Update Status
	  if($sqlUpdate){
	    echo "<script>alert('Record has been updated!');</script>";
			echo "<script>window.location.href='business-venueManagement-contactUs.php'</script>";
	  }
		else {
			echo "<script>alert('There is a problem updating this record. Please try again.');</script>";
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
		<title>ASport for Business | Contact Us</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Contact Us');
		include_once('includes/business-header.php');
		include_once('includes/business-sidebar.php');
		?>

		<!--start of division class 1-->
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<!--start of division class 2-->
			<div class="row">
				<!--start of ordered list-->
				<ol class="breadcrumb">
					<!--start of list-->
					<li><a href="business-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Venue Management -> Contact Us</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Contact Us</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4><b><span class="fa fa-pencil"></span>&nbsp Last Update: </b><?php echo $timeStampLastEditContactUs ?></h4>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<form role="form" method="post" action="">
								<h3 align="center"><b><span class="fa fa-phone"></span><br>Contact Us</b></h3>
									<div class="col-md-2"></div>
									<div class="col-md-8">
										<div class="form-group">
		                  <label><span class="fa fa-phone"></span>&nbsp Phone Number</label>
		                  <input class="form-control" type="text" name="businessPhoneNumber" required="true" value="<?php echo $current_businessPhoneNumber ?>">
		                </div>
										<div class="form-group">
											<label><span class="fa fa-envelope"></span>&nbsp Email</label>
											<input class="form-control" type="text" name="businessEmail" value="<?php echo $current_businessEmail ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-facebook-official"></span>&nbsp Facebook Link</label>
											<input class="form-control" type="text" name="facebookLink" value="<?php echo $current_facebookLink ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-twitter"></span>&nbsp Twitter Link</label>
											<input class="form-control" type="text" name="twitterLink" value="<?php echo $current_twitterLink ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-instagram"></span>&nbsp Instagram Link</label>
											<input class="form-control" type="text" name="instagramLink" value="<?php echo $current_instagramLinkl ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-youtube-play"></span>&nbsp YouTube Link</label>
											<input class="form-control" type="text" name="youtubeLink" value="<?php echo $current_youtubeLink ?>">
										</div>
										<br>
										<div align="center" class="form-group has-success">
											<button type="submit" class="btn btn-primary" name="submit" style="width: 25%;"><b>UPDATE</b></button>
										</div>
									</div>
									<div class="col-md-2"></div>
								</form>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row-->

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
