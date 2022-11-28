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
	$userBookingID = $_GET['userBookingID'];

	$sql = "SELECT * FROM userBookings
					WHERE userBookingID=$userBookingID AND userID=$userID";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$userBookingID = $data['userBookingID'];
		$businessFacilityID = $data['businessFacilityID'];
		$userLoyaltyTransactionID = $data['userLoyaltyTransactionID'];
		$bookingDate = $data['bookingDate'];
		$bookingStartTime = $data['bookingStartTime'];
		$bookingEndTime = $data['bookingEndTime'];
		$bookingDuration = $data['bookingDuration'];
		$bookingVenue = $data['bookingVenue'];
		$bookingCategory = $data['bookingCategory'];
		$bookingFacilityNo = $data['bookingFacilityNo'];
		$bookingPrice = $data['bookingPrice'];
		$bookingTransactionTimeStamp = $data['bookingTransactionTimeStamp'];
		$bookingIsCancelled = $data['bookingIsCancelled'];
		$bookingIsCancelledTimeStamp = $data['bookingIsCancelledTimeStamp'];
	}

	//FOR CANCELLATION ELIGIBILITY CHECK
	$todayDate = date('Y-m-d', time());
	//cancellation can only be made before the booking date
	if ($bookingDate<=$todayDate) {
		$cancellationIneligible = true;
	}

	$sql = "SELECT * FROM userLoyaltyTransactions
					WHERE userLoyaltyTransactionID=$userLoyaltyTransactionID AND userBookingID=$userBookingID AND userID=$userID";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$pointsAddedAmount = $data['pointsAddedAmount'];
		$pointsAddedTimeStamp = $data['pointsAddedTimeStamp'];
		$pointsDeductedAmount = $data['pointsDeductedAmount'];
		$pointsDeductedTimeStamp = $data['pointsDeductedTimeStamp'];
	}

	$sql = "SELECT * FROM businessFacility WHERE businessFacilityID='$businessFacilityID'";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$layoutFileName = $data['layoutFileName'];
	}

	$sql =
	"SELECT businessFacility.businessID, business.businessName, businessVenueManagement.locationCity, businessVenueManagement.locationState, businessVenueManagement.coverImageFileName
	FROM businessFacility, business, businessVenueManagement
	WHERE businessFacility.businessFacilityID = $businessFacilityID AND businessFacility.businessID=business.businessID AND businessVenueManagement.businessID=business.businessID
	";
	$result = mysqli_query($con,$sql);
	while ($column = $result->fetch_assoc()){
		$businessID = $column['businessID'];
		$businessName = $column['businessName'];
		$locationCity = $column['locationCity'];
		$locationState = $column['locationState'];
		$coverImageFileName = $column['coverImageFileName'];
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
		<title>ASport | Booking Receipt</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		$date_now = date("Y-m-d");
		//include the header and the sidebar
		if ($bookingIsCancelled) {
			define('PAGE', 'Cancelled');
			$breadcrumb = "Cancelled";
		}
		else {
			if ($bookingDate>= $date_now) {
				define('PAGE', 'Upcoming');
				$breadcrumb = "Upcoming";
			} else {
				define('PAGE', 'Past');
				$breadcrumb = "Past";
			}
		}
		include_once('includes/user-header.php');
		include_once('includes/user-sidebar.php');
		?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="user-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">My Bookings -> <?php echo $breadcrumb ?> -> Booking Receipt</li>
				</ol>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Booking Receipt</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<?php if ($bookingIsCancelled): ?>
								<br><br>
								<img src="images/cross.png" width="100" height="100">
								<br><br>
								<h3 style="color:red"><b>Booking Cancelled On<br><br><tt><?php echo $bookingIsCancelledTimeStamp ?></tt></b></h3>
								<br><br>
							<?php else: ?>
								<h3><b>QR Code</b></h3>
								<p>
									<canvas id="qr-code"></canvas>
									<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
									<script>
										var qr;
										(function() {
												qr = new QRious({
												element: document.getElementById('qr-code'),
												size: 200,
												value: 'userBookingID=<?php echo $userBookingID ?>&userID=<?php echo $userID ?>'
											});
										})();
									</script>
								</p>
								<h5>Present this QR code at check-in counter for entry verification.</h5>
							<?php endif; ?>
						</div>
					</div>
				</div>


				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Loyalty Points Earned For<br><br>This Transaction</b></h3><br>
							<center>
								<table>
									<tr>
										<td><img src="images/loyalty.png" width="100" height="100">&nbsp &nbsp &nbsp &nbsp</td>
										<td>
											<div class="easypiechart" id="easypiechart-blue" data-percent="100" >
												<span class="percent">
													<?php if ($bookingIsCancelled): ?>
														<?php echo "0" ?>
													<?php else: ?>
														<?php echo "$pointsAddedAmount" ?>
													<?php endif; ?>
												</span>
											</div>
										</td>
									</tr>
								</table>
							</center><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-body">
	            <h3 align="center"><b>Booking Receipt</b></h3>
	              <div class="col-md-1"></div>
	  						<div class="col-md-10">
									<div class="form-group">
										<label><span class="fa fa-id-card-o"></span>&nbsp Booking ID</label>
										<p class="form-control" type="text" name="bookingID"><?php echo $userBookingID ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-calendar"></span>&nbsp Date</label>
										<p class="form-control" type="text" name="bookingDate"><?php echo $bookingDate ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Start Time</label>
										<p class="form-control" type="text" name="bookingStartTime"><?php echo $bookingStartTime ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp End Time</label>
										<p class="form-control" type="text" name="bookingEndTime"><?php echo $bookingEndTime ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-list"></span>&nbsp Duration (hour)</label>
										<p class="form-control" type="text" name="bookingDuration"><?php echo $bookingDuration ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-location-arrow"></span>&nbsp Venue</label>
										<p class="form-control" type="text" name="bookingVenue"><?php echo $bookingVenue ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-th-large"></span>&nbsp Category</label>
										<p class="form-control" type="text" name="bookingCategory"><?php echo $bookingCategory ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-info-circle"></span>&nbsp Facility No (Court No)</label>
										<p class="form-control" type="text" name="bookingFacilityNo"><?php echo $bookingFacilityNo ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price (RM)</label>
										<p class="form-control" type="text" name="bookingPrice"><?php echo $bookingPrice ?></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-calendar-minus-o"></span>&nbsp Transaction Date & Time</label>
										<p class="form-control" type="text" name="bookingTransactionTimeStamp"><?php echo $bookingTransactionTimeStamp ?></p>
									</div>
	                <br>
									<div align="center" class="form-group has-success">
										<?php if ($bookingIsCancelled || $cancellationIneligible): ?>
											<a class="btn btn-danger" style="width: 40%;" disabled>
												<b>CANCEL BOOKING</b>
											</a>
										<?php else: ?>
											<a href="user-bookings-cancellation.php?userBookingID=<?php echo $userBookingID ?>"
												onclick="return confirm('Are you sure to cancel this booking? This action cannot be reverted!')"
												class="btn btn-danger"
												style="width: 40%;"
											>
												<b><span class="fa fa-times"></span>&nbsp CANCEL BOOKING</b>
											</a>
										<?php endif; ?>
									</div>
									<center>
										<p style="color: red"><b><tt>* Cancellation can only be made before the booking date. *</tt></b></p>
										<p><b><tt>
											<a href="user-helpCentre-faq.php" target="blank">View Frequently Asked Questions</a>
											<br>
											<a href="user-helpCentre-tnc.php" target="blank">View Terms & Conditions</a>
										</tt></b></p>
									</center>
	              </div>
								<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

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
 						 <?php if ($coverImageFileName): ?>
 							 <p><img src="<?php echo $coverImageFileName ?>" width="100%" height="250"></p>
 						 <?php else: ?>
 							 <center><img src="images/icon-noImageAvailable.png" height="250"></center>
 						 <?php endif; ?>
 						 <h3><b><?php echo $businessName ?></b></h3>
 						 <h5><b><?php echo "$locationCity, $locationState"; ?></b></h5>
 						 <p>
 							 <a href="user-venueInformation.php?businessID=<?php echo $businessID ?>" target="_blank" class="btn btn-warning" style="width: 45%;"><b>VENUE DETAILS</b></a>
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
