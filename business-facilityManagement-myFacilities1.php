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
?>

	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ASport for Business | My Facilities</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>
	</head>

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'My Facilities');
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
					<li class="active">Facility Management -> My Facilities</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">My Facilities</div>
					</div>
				</div>
			</div>

			<div class="row">
				<?php
				$sql = "SELECT * FROM businessFacility WHERE businessID='$businessID'";
				$result = mysqli_query($con,$sql);

				if (mysqli_num_rows($result) == 0) {
				?>
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br>
								<p><img src="images/warning.png" width="180" height="180"></p>
								<h3><b>No Facility Found</b></h4><br>
								<a href="business-facilityManagement-addNewFacility.php"><button class="btn btn-primary" ><i class="fa fa-plus fa-lg"></i><b>&nbsp ADD A NEW FACILITY</b></button></a>
								<br><br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
				<?php
				}
				else {
					while ($column = $result->fetch_array()){
						$businessFacilityID = $column['businessFacilityID'];
						$businessFacilityCategoryID = $column['businessFacilityCategoryID'];
					?>
						<?php if ($businessFacilityCategoryID==1) { ?>
							<div class="col-md-4">
								<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
									<div class="panel panel-default">
										<div class="panel-body easypiechart-panel">
											<h3><b>Badminton</b></h4>
											<p><img src="images/badminton.png" width="200" height="200"></p>
										</div><!-- /.panel-body-->
									</div><!-- /.panel-->
								</a>
							</div><!-- /.col-->
						<?php } ?>
						<?php if ($businessFacilityCategoryID==2) { ?>
							<div class="col-md-4">
								<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
									<div class="panel panel-default">
										<div class="panel-body easypiechart-panel">
											<h3><b>Basketball</b></h4>
											<p><img src="images/basketball.png" width="200" height="200"></p>
										</div><!-- /.panel-body-->
									</div><!-- /.panel-->
								</a>
							</div><!-- /.col-->
						<?php } ?>
						<?php if ($businessFacilityCategoryID==3) { ?>
							<div class="col-md-4">
								<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
									<div class="panel panel-default">
										<div class="panel-body easypiechart-panel">
											<h3><b>Football</b></h4>
											<p><img src="images/football.png" width="200" height="200"></p>
										</div><!-- /.panel-body-->
									</div><!-- /.panel-->
								</a>
							</div><!-- /.col-->
						<?php } ?>
						<?php if ($businessFacilityCategoryID==4) { ?>
							<div class="col-md-4">
								<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
									<div class="panel panel-default">
										<div class="panel-body easypiechart-panel">
											<h3><b>Futsal</b></h4>
											<p><img src="images/futsal.png" width="200" height="200"></p>
										</div><!-- /.panel-body-->
									</div><!-- /.panel-->
								</a>
							</div><!-- /.col-->
						<?php } ?>
						<?php if ($businessFacilityCategoryID==5) { ?>
							<div class="col-md-4">
								<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
									<div class="panel panel-default">
										<div class="panel-body easypiechart-panel">
											<h3><b>Squash</b></h4>
											<p><img src="images/squash.png" width="200" height="200"></p>
										</div><!-- /.panel-body-->
									</div><!-- /.panel-->
								</a>
							</div><!-- /.col-->
						<?php } ?>
						<?php if ($businessFacilityCategoryID==6) { ?>
							<div class="col-md-4">
								<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
									<div class="panel panel-default">
										<div class="panel-body easypiechart-panel">
											<h3><b>Tennis</b></h4>
											<p><img src="images/tennis.png" width="200" height="200"></p>
										</div><!-- /.panel-body-->
									</div><!-- /.panel-->
								</a>
							</div><!-- /.col-->
						<?php } ?>
					<?php
					}
				}
				?>
			</div><!-- /.row-->

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

		<!--javascript source-->
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>
		<script src="js/chart-data.js"></script>
		<script src="js/easypiechart.js"></script>
		<script src="js/easypiechart-data.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="js/custom.js"></script>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

	</body>
	<!--end of body-->

	</html>
	<!--end of html-->

<?php
}
?>
