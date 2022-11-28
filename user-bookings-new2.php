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
	$businessFacilityCategoryID = $_GET['businessFacilityCategoryID'];

	if ($businessFacilityCategoryID==1) {
		$title = "Badminton";
	}
	elseif ($businessFacilityCategoryID==2) {
		$title = "Basketball";
	}
	elseif ($businessFacilityCategoryID==3) {
		$title = "Football";
	}
	elseif ($businessFacilityCategoryID==4) {
		$title = "Futsal";
	}
	elseif ($businessFacilityCategoryID==5) {
		$title = "Squash";
	}
	elseif ($businessFacilityCategoryID==6) {
		$title = "Tennis";
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
		<title>ASport | New Booking</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'New Booking');
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
					<li class="active">New Booking -> <?php echo $title ?></li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading"><?php echo $title ?></div>
					</div>
				</div>
			</div>

			<!-- <div class="row">
				<div class="col-md-12">
					<h4 align="left"><font color="#30a5ff"><span class="fa fa-search"></span></font>&nbsp &nbsp<tt><input id="myInput" type="text" placeholder="Search.."></tt></h4>
				</div>
			</div> -->

			<div class="row">
				<?php
					$sql =
					"SELECT businessFacility.businessFacilityID, businessFacility.businessID, business.businessName, businessVenueManagement.locationCity, businessVenueManagement.locationState, businessVenueManagement.coverImageFileName
					FROM businessFacility, business, businessVenueManagement
					WHERE businessFacility.businessFacilityCategoryID='$businessFacilityCategoryID' AND businessFacility.businessID=business.businessID AND businessVenueManagement.businessID=business.businessID
					";
					$result = mysqli_query($con,$sql);
					while ($column = $result->fetch_assoc()){
						$businessFacilityID = $column['businessFacilityID'];
						$businessID = $column['businessID'];
						$businessName = $column['businessName'];
						$locationCity = $column['locationCity'];
						$locationState = $column['locationState'];
						$coverImageFileName = $column['coverImageFileName'];
				 ?>
					 <div class="col-md-4">
						 <div class="panel panel-default">
							 <div class="panel-body easypiechart-panel">
								 <?php if ($coverImageFileName): ?>
									 <p><img src="<?php echo $coverImageFileName ?>" width="100%" height="250"></p>
								 <?php else: ?>
									 <center><img src="images/icon-noImageAvailable.png" height="250"></center>
								 <?php endif; ?>
								 <h3><b><?php echo $businessName ?></b></h3>
								 <h5><b><?php echo "$locationCity, $locationState"; ?></b></h5>
								 <p>
									 <a href="user-venueInformation.php?businessID=<?php echo $businessID ?>" class="btn btn-warning" style="width: 45%;"><b>VENUE DETAILS</b></a>
									 <a href="user-bookings-new3.php?businessFacilityID=<?php echo $businessFacilityID ?>" class="btn btn-primary" style="width: 45%;"><b>BOOK NOW</b></a>
								 </p>
							 </div>
						 </div>
					 </div>

				 <?php
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
