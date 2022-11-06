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

	if(isset($_POST['next'])){
		$bookingDate = $_POST['bookingDate'];
		$bookingFacilityNo = $_POST['bookingFacilityNo'];
		$bookingStartTime = $_POST['bookingStartTime'];
		$bookingDuration = $_POST['bookingDuration'];

		$businessFacilityID = $_POST['businessFacilityID'];
		$bookingDate = $_POST['bookingDate'];
		$bookingCategory = $_POST['bookingCategory'];
		$bookingVenue = $_POST['bookingVenue'];
		$slotPrice = $_POST['slotPrice'];

		$bookingPrice = $slotPrice * $bookingDuration;
		$bookingEndTime = date('H:i',strtotime($bookingStartTime.'+'.$bookingDuration.' hours'));

		$sql = "SELECT * FROM businessFacility WHERE businessFacilityID='$businessFacilityID'";
		$result = mysqli_query($con,$sql);
		while ($data = $result->fetch_assoc()){
			$businessFacilityID = $data['businessFacilityID'];
			$businessFacilityCategoryID = $data['businessFacilityCategoryID'];

			$totalNo = $data['totalNo'];

			$mondayIsOpen = $data['mondayIsOpen'];
			$mondayOpeningTime = date('H:i',strtotime($data['mondayOpeningTime']));
			$mondayClosingTime = date('H:i',strtotime($data['mondayClosingTime']));
			$mondayPrice = $data['mondayPrice'];

			$tuesdayIsOpen = $data['tuesdayIsOpen'];
			$tuesdayOpeningTime = date('H:i',strtotime($data['tuesdayOpeningTime']));
			$tuesdayClosingTime = date('H:i',strtotime($data['tuesdayClosingTime']));
			$tuesdayPrice = $data['tuesdayPrice'];

			$wednesdayIsOpen = $data['wednesdayIsOpen'];
			$wednesdayOpeningTime = date('H:i',strtotime($data['wednesdayOpeningTime']));
			$wednesdayClosingTime = date('H:i',strtotime($data['wednesdayClosingTime']));
			$wednesdayPrice = $data['wednesdayPrice'];

			$thursdayIsOpen = $data['thursdayIsOpen'];
			$thursdayOpeningTime = date('H:i',strtotime($data['thursdayOpeningTime']));
			$thursdayClosingTime = date('H:i',strtotime($data['thursdayClosingTime']));
			$thursdayPrice = $data['thursdayPrice'];

			$fridayIsOpen = $data['fridayIsOpen'];
			$fridayOpeningTime = date('H:i',strtotime($data['fridayOpeningTime']));
			$fridayClosingTime = date('H:i',strtotime($data['fridayClosingTime']));
			$fridayPrice = $data['fridayPrice'];

			$saturdayIsOpen = $data['saturdayIsOpen'];
			$saturdayOpeningTime = date('H:i',strtotime($data['saturdayOpeningTime']));
			$saturdayClosingTime = date('H:i',strtotime($data['saturdayClosingTime']));
			$saturdayPrice = $data['saturdayPrice'];

			$sundayIsOpen = $data['sundayIsOpen'];
			$sundayOpeningTime = date('H:i',strtotime($data['sundayOpeningTime']));
			$sundayClosingTime = date('H:i',strtotime($data['sundayClosingTime']));
			$sundayPrice = $data['sundayPrice'];

			$timeStampAdded = $data['timeStampAdded'];
			$timeStampEdited = $data['timeStampEdited'];

			$layoutFileName = $data['layoutFileName'];
		}

		$sql =
		"SELECT businessFacility.businessID, business.businessName, businessVenueManagement.locationCity, businessVenueManagement.locationState
		FROM businessFacility, business, businessVenueManagement
		WHERE businessFacility.businessFacilityID = $businessFacilityID AND businessFacility.businessID=business.businessID AND businessVenueManagement.businessID=business.businessID
		";
		$result = mysqli_query($con,$sql);
		while ($column = $result->fetch_assoc()){
			$businessID = $column['businessID'];
			$businessName = $column['businessName'];
			$locationCity = $column['locationCity'];
			$locationState = $column['locationState'];

			$str = $businessName;
			$new_str = str_replace(' ', '', $str);
			$imageFilePath = "images/facilities-".$new_str.".png";
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
					<li class="active">New Booking</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Booking Confirmation</div>
					</div>
				</div>
			</div>

			<form method="post" action="user-bookings-new5.php">
			<div class="row">
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>Booking Confirmation</b></h3>
								<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="form-group">
										<label><span class="fa fa-calendar"></span>&nbsp Date</label>
										<input class="form-control" type="text" name="bookingDate" value="<?php echo $bookingDate ?>" readonly>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Start Time</label>
										<input class="form-control" type="text" name="bookingStartTime" value="<?php echo $bookingStartTime ?>" readonly>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp End Time</label>
										<input class="form-control" type="text" name="bookingEndTime" value="<?php echo $bookingEndTime ?>" readonly>
									</div>
									<div class="form-group">
										<label><span class="fa fa-list"></span>&nbsp Duration (hour)</label>
										<input class="form-control" type="text" name="bookingDuration" value="<?php echo $bookingDuration ?>" readonly>
									</div>
									<div class="form-group">
										<label><span class="fa fa-location-arrow"></span>&nbsp Venue</label>
										<input class="form-control" type="text" name="bookingVenue" value="<?php echo $bookingVenue ?>" readonly>
									</div>
									<div class="form-group">
										<label><span class="fa fa-th-large"></span>&nbsp Category</label>
										<input class="form-control" type="text" name="bookingCategory" value="<?php echo $bookingCategory ?>" readonly>
									</div>
									<div class="form-group">
										<label><span class="fa fa-info-circle"></span>&nbsp Facility No (Court No)</label>
										<input class="form-control" type="text" name="bookingFacilityNo" value="<?php echo $bookingFacilityNo ?>" readonly>
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price (RM)</label>
										<input class="form-control" type="text" name="bookingPrice" value="<?php echo $bookingPrice ?>" readonly>
									</div>
	                <br>
									<input type="hidden" name="bookingLoyaltyPoints" value="<?php echo $bookingPrice ?>">
									<input type="hidden" name="businessFacilityID" value="<?php echo $businessFacilityID ?>">
	                <div align="center" class="form-group has-success">
	                  <button type="submit" class="btn btn-primary" name="submit" style="width: 50%;"><b>PROCEED TO PAYMENT</b></button>
	                </div>
	              </div>
								<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				</form>

				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<center>
								<h3><b>Facility Information</b></h3>
								<table>
									<tr>
										<td style="border:none; text-align:right;" width="55%"><img src="images/<?php echo $bookingCategory ?>.png" width="200" height="200"></td>
										<td style="border:none; text-align:left;" width="45%">
											<h4><b>&nbsp &nbsp <?php echo $bookingCategory ?></b></h4>
											<h4><b>&nbsp &nbsp Court <?php echo $bookingFacilityNo ?></b></h4>
										</td>
									</tr>
								</table><br>
							</center>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Facility Layout</b></h3><br>
							<?php if ($layoutFileName): ?>
								<p><img src="<?php echo $layoutFileName;?>" width="80%" height="80%" style="border: 1px solid"></p><br>
							<?php else: ?>
								<center><img src="images/icon-noImageAvailable.png" width="50%" height="50%"></center><br><br>
							<?php endif; ?>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

			 <div class="col-md-5">
				 <div class="panel panel-default">
					 <div class="panel-body easypiechart-panel">
						 <h3><b>Venue Information</b></h3>
						 <p><img src="<?php echo $imageFilePath ?>" width="100%" height="250"></p>
						 <h3><b><?php echo $businessName ?></b></h3>
						 <h5><b><?php echo "$locationCity, $locationState"; ?></b></h5>
						 <p>
							 <a href="" class="btn btn-warning" style="width: 45%;"><b>VENUE DETAILS</b></a>
						 </p>
					 </div>
				 </div>
			 </div>

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
