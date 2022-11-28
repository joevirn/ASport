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
		$current_locationAddressLine1 = $row['locationAddressLine1'];
		$current_locationAddressLine2 = $row['locationAddressLine2'];
		$current_locationCity = $row['locationCity'];
		$current_locationState = $row['locationState'];
		$current_locationPostcode = $row['locationPostcode'];
		$timeStampLastEditLocation = $row['timeStampLastEditLocation'];
	}

	if(isset($_POST['submit']))
	{
		$locationAddressLine1 = $_POST['locationAddressLine1'];
		$locationAddressLine2 = $_POST['locationAddressLine2'];
		$locationCity = $_POST['locationCity'];
		$locationState = $_POST['locationState'];
		$locationPostcode = $_POST['locationPostcode'];

		//ADD FORM FIELDS TO DATABASE
	  $sqlUpdate = mysqli_query($con,
	    "UPDATE
				businessVenueManagement
			SET
				locationAddressLine1 = '$locationAddressLine1',
				locationAddressLine2 = '$locationAddressLine2',
				locationCity = '$locationCity',
				locationState = '$locationState',
				locationPostcode = '$locationPostcode',
				timeStampLastEditLocation = now()
			WHERE
				businessVenueManagementID = '$businessVenueManagementID'
				AND
				businessID = '$businessID'
			");

		//JAVASCRIPT ALERT STATUS
		//Record Update Status
	  if($sqlUpdate){
	    echo "<script>alert('Record has been updated!');</script>";
			echo "<script>window.location.href='business-venueManagement-location.php'</script>";
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
		<title>ASport for Business | Location</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->
	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Location');
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
					<li class="active">Venue Management -> Location</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Location</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4><b>
								<span class="fa fa-pencil"></span>&nbsp Last Update: </b>
								<?php if ($timeStampLastEditLocation): ?>
									<?php echo $timeStampLastEditLocation; ?>
								<?php else: ?>
									No Updates Recorded
								<?php endif; ?>
							</h4>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<form role="form" method="post" action="">
		            <h3 align="center"><b><span class="fa fa-map"></span><br>Location</b></h3>
		              <div class="col-md-1"></div>
		  						<div class="col-md-10">
		                <div class="form-group">
		                  <label><span class="fa fa-info-circle"></span>&nbsp Address Line 1</label>
		                  <input class="form-control" type="text" name="locationAddressLine1" value="<?php echo $current_locationAddressLine1 ?>">
		                </div>
										<div class="form-group">
											<label><span class="fa fa-info-circle"></span>&nbsp Address Line 2</label>
											<input class="form-control" type="text" name="locationAddressLine2" value="<?php echo $current_locationAddressLine2 ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-info-circle"></span>&nbsp City</label>
											<input class="form-control" type="text" name="locationCity" value="<?php echo $current_locationCity ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-info-circle"></span>&nbsp State</label>
											<input class="form-control" type="text" name="locationState" value="<?php echo $current_locationState ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-info-circle"></span>&nbsp Postcode</label>
											<input class="form-control" type="text" name="locationPostcode" value="<?php echo $current_locationPostcode ?>">
										</div>
										<br>
										<div align="center" class="form-group has-success">
											<button type="submit" class="btn btn-primary" name="submit" style="width: 25%;"><b>UPDATE</b></button>
										</div>
		              </div>
									<div class="col-md-1"></div>
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
