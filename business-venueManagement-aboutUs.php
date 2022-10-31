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
		$current_aboutUsLine1 = $row['aboutUsLine1'];
		$current_aboutUsLine2 = $row['aboutUsLine2'];
		$current_aboutUsLine3 = $row['aboutUsLine3'];
		$current_aboutUsLine4 = $row['aboutUsLine4'];
		$current_aboutUsLine5 = $row['aboutUsLine5'];
		$timeStampLastEditAboutUs = $row['timeStampLastEditAboutUs'];
	}

	if(isset($_POST['submit']))
	{
		$aboutUsLine1 = $_POST['aboutUsLine1'];
		$aboutUsLine2 = $_POST['aboutUsLine2'];
		$aboutUsLine3 = $_POST['aboutUsLine3'];
		$aboutUsLine4 = $_POST['aboutUsLine4'];
		$aboutUsLine5 = $_POST['aboutUsLine5'];

		//ADD FORM FIELDS TO DATABASE
	  $sqlUpdate = mysqli_query($con,
	    "UPDATE
				businessVenueManagement
			SET
				aboutUsLine1 = '$aboutUsLine1',
				aboutUsLine2 = '$aboutUsLine2',
				aboutUsLine3 = '$aboutUsLine3',
				aboutUsLine4 = '$aboutUsLine4',
				aboutUsLine5 = '$aboutUsLine5',
				timeStampLastEditAboutUs = now()
			WHERE
				businessVenueManagementID = '$businessVenueManagementID'
				AND
				businessID = '$businessID'
			");

		//JAVASCRIPT ALERT STATUS
		//Record Update Status
	  if($sqlUpdate){
	    echo "<script>alert('Record has been updated!');</script>";
			echo "<script>window.location.href='business-venueManagement-aboutUs.php'</script>";
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
		<title>ASport for Business | About Us</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->
	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'About Us');
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
					<li class="active">Venue Management -> About Us</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">About Us</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4><b><span class="fa fa-pencil"></span>&nbsp Last Update: </b><?php echo $timeStampLastEditAboutUs ?></h4>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<form role="form" method="post" action="">
		            <h3 align="center"><b>About Us</b></h3>
		              <div class="col-md-1"></div>
		  						<div class="col-md-10">
		                <div class="form-group">
		                  <label><span class="fa fa-info-circle"></span>&nbsp Line 1</label>
		                  <input class="form-control" type="text" name="aboutUsLine1" value="<?php echo $current_aboutUsLine1 ?>">
		                </div>
										<div class="form-group">
											<label><span class="fa fa-info-circle"></span>&nbsp Line 2</label>
											<input class="form-control" type="text" name="aboutUsLine2" value="<?php echo $current_aboutUsLine2 ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-info-circle"></span>&nbsp Line 3</label>
											<input class="form-control" type="text" name="aboutUsLine3" value="<?php echo $current_aboutUsLine3 ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-info-circle"></span>&nbsp Line 4</label>
											<input class="form-control" type="text" name="aboutUsLine4" value="<?php echo $current_aboutUsLine4 ?>">
										</div>
										<div class="form-group">
											<label><span class="fa fa-info-circle"></span>&nbsp Line 5</label>
											<input class="form-control" type="text" name="aboutUsLine5" value="<?php echo $current_aboutUsLine5 ?>">
										</div>
										<br>
										<div align="center" class="form-group has-success">
											<button type="submit" class="btn btn-primary" name="submit" style="width: 25%;">UPDATE</button>
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
