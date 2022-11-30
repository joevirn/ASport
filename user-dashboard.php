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

	$sql = "SELECT * FROM userBookings
					WHERE userID=$userID AND bookingIsCancelled IS NULL AND bookingDate >= CURDATE() ORDER BY bookingDate ASC, bookingStartTime ASC LIMIT 1";
	$result = mysqli_query($con,$sql);
	if (mysqli_num_rows($result) == 0) {
		$noNextBooking = true;
	}
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

	//GET PONTS BALANCE
	$sql = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID ORDER BY userLoyaltyTransactionID DESC LIMIT 1";
	$result = mysqli_query($con,$sql);
	if (mysqli_num_rows($result) == 0) {
		$pointsBalance = 0;
	}
	else {
		while ($row = $result->fetch_assoc()){
			$pointsBalance = $row['pointsBalance'];
		}
	}

	//GET TOTAL NO OF UPCOMING BOOKINGS
	$sql = "SELECT * FROM userBookings WHERE userID=$userID AND bookingIsCancelled IS NULL AND bookingDate >= CURDATE()";
	$result = mysqli_query($con,$sql);
	if (mysqli_num_rows($result) == 0) {
		$upcomingBookingsCount = 0;
	}
	else {
		while ($row = $result->fetch_assoc()){
			$upcomingBookingsCount++;
		}
	}

	//GET TOTAL NO OF PAST BOOKINGS
	$sql = "SELECT * FROM userBookings WHERE userID=$userID AND bookingIsCancelled IS NULL AND bookingDate < CURDATE()";
	$result = mysqli_query($con,$sql);
	if (mysqli_num_rows($result) == 0) {
		$pastBookingsCount = 0;
	}
	else {
		while ($row = $result->fetch_assoc()){
			$pastBookingsCount++;
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
		<title>ASport | Dashboard</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
	</head>

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Dashboard');
		include_once('includes/user-header.php');
		include_once('includes/user-sidebar.php');
		?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<br>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Dashboard</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-teal">
						<div class="panel-heading"><center>YOUR NEXT BOOKING</center></div>
					</div>
				</div>
				<?php if ($noNextBooking==true): ?>
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-ticket"></span><br>No Next Booking Found</b></h3><br>
								<a href="user-bookings-new1.php"><button class="btn bg-teal" ><i class="fa fa-calendar-plus-o"></i><b>&nbsp MAKE A NEW BOOKING</b></button></a>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
				<?php else: ?>
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-ticket"></span><br>QR Code</b></h3><br>
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
								<h5>Present this QR code at check-in counter<br>for entry verification.</h5>
								<br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-info"></span><br>Booking Information</b></h3><br>
								<h3><tt><b><span class="fa fa-calendar"></span>&nbsp<?php echo $bookingDate ?></b></tt></h3>
								<h3><tt><b><span class="fa fa-clock-o"></span>&nbsp<?php echo $bookingStartTime ?> - <?php echo $bookingEndTime ?></b></tt></h3>
								<h3><tt><b><span class="fa fa-clock-o"></span>&nbsp<?php echo $bookingDuration ?> hour(s)</b></tt></h3>
								<h3><tt><b><span class="fa fa-ticket"></span>&nbspBooking ID : <?php echo $userBookingID ?></b></tt></h3>
								<br>
								<a href="user-bookings-receipt.php?userBookingID=<?php echo $userBookingID ?>"><button class="btn bg-teal" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW BOOKING RECEIPT</b></button></a>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-map"></span><br>Venue & Facility Information</b></h3>
								<h3><tt><b><span class="fa fa-location-arrow"></span>&nbsp<?php echo $bookingVenue ?></b></tt></h3><br>
								<table>
									<tr>
										<td style="border:none; text-align:right;" width="55%"><img src="images/<?php echo $bookingCategory ?>.png" width="200" height="200"></td>
										<td style="border:none; text-align:left;" width="45%">
											<h3><b><tt>&nbsp &nbsp<?php echo $bookingCategory ?></tt></b></h3>
											<h3><b><tt>&nbsp &nbsp Court <?php echo $bookingFacilityNo ?></tt></b></h3>
										</td>
									</tr>
								</table>
								<br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
				<?php endif; ?>

			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-warning">
						<div class="panel-heading"><center>ANALYTICS AT A GLANCE</center></div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-star"></span><br>Loyalty Points Balance</b></h3>
							<center>
								<table>
								<tr>
									<td><img src="images/loyalty.png" width="100" height="100">&nbsp &nbsp &nbsp &nbsp</td>
									<td>
										<div class="easypiechart" id="easypiechart-blue" data-percent="100" >
											<span class="percent"><?php echo $pointsBalance ?></span>
										</div>
									</td>
								</tr>
							</table>
							<a href="user-loyalty-points.php"><button class="btn btn-primary" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW DETAILS</b></button></a>
							<br><br>
						</center>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-arrow-up"></span><br>Upcoming Bookings</b></h3>
							<div class="easypiechart" id="easypiechart-teal" data-percent="100" >
								<span class="percent">
									<?php echo "$upcomingBookingsCount" ?>
								</span>
							</div>
							<a href="user-bookings-upcoming.php"><button type="submit" name="upload" class="btn bg-teal" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW DETAILS</b></button></a>
							<br><br>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-arrow-down"></span><br>Past Bookings</b></h3>
							<div class="easypiechart" id="easypiechart-orange" data-percent="100" >
								<span class="percent">
									<?php echo "$pastBookingsCount" ?>
								</span>
							</div>
							<a href="user-bookings-past.php"><button type="submit" name="upload" class="btn bg-orange" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW DETAILS</b></button></a>
							<br><br>
						</div>
					</div>
				</div>
			</div>


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
