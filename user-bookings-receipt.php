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
		//include the header and the sidebar
		define('PAGE', 'Upcoming');
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
					<li class="active">Booking Receipt</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

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
											value: 'ASport/bookingID=<?php echo $userBookingID ?>&userID=<?php echo $userID ?>'
										});
									})();
								</script>
							</p>
							<h5>Present this QR code at check-in counter for entry verification.</h5>
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
												<?php echo "$pointsAddedAmount" ?>
											</span>
										</div>
									</td>
								</tr>
							</table>
						</center><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

				<form method="post" action="">
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
	                  <button type="submit" class="btn btn-default" name="submit" style="width: 30%;">PRINT</button> &nbsp
										<button type="submit" class="btn btn-default" name="submit" style="width: 30%;">SAVE AS PDF</button>
	                </div>
									<div align="center" class="form-group has-success">
										<button type="submit" class="btn btn-danger" name="submit" style="width: 40%;">CANCEL BOOKING</button>
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
							 <a href="" class="btn btn-default" style="width: 45%;">Complex Details</a>
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
