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
	<!--start of html-->
	<html>

	<!--start of head-->

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport for Business | Add A New Booking</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->
	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'New');
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
					<li class="active">Bookings Management -> Add A New Booking</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Add A New Booking</div>
					</div>
				</div>
			</div>

			<div class="row">
				<?php
				$sql = "SELECT * FROM businessFacility WHERE businessID='$businessID'";
				$result = mysqli_query($con,$sql);

				while ($column = $result->fetch_array()){
					$businessFacilityID = $column['businessFacilityID'];
					$businessFacilityCategoryID = $column['businessFacilityCategoryID'];
				?>
					<?php if ($businessFacilityCategoryID==1) { ?>
						<div class="col-md-4">
							<a href="business-bookingsManagement-new2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
							<a href="business-bookingsManagement-new2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
							<a href="business-bookingsManagement-new2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
							<a href="business-bookingsManagement-new2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
							<a href="business-bookingsManagement-new2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
							<a href="business-bookingsManagement-new2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
				?>
			</div><!-- /.row-->

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

	</body>
	<!--end of body-->

	</html>
	<!--end of html-->

<?php
}
?>
