<?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the user id in the session is being cleared, log out the user
if (strlen($_SESSION['ASportBusinessSessionCounter'] == 0)) {
	header('location:business-logout.php');
}
else {
	$businessID = $_SESSION['ASportBusinessSessionCounter'];
	$userBookingID = $_GET['userBookingID'];
	$userID = $_GET['userID'];

	if ($userBookingID && $userID) {

		$sqlGetBusinessName = "SELECT businessName FROM business WHERE businessID=$businessID";
		$resultBusinessName = mysqli_query($con,$sqlGetBusinessName);
		while ($dataBusinessName = $resultBusinessName->fetch_assoc()){
			$businessName = $dataBusinessName['businessName'];
		}

		$sqlGetUserDetails = "SELECT * FROM users WHERE userID=$userID";
		$resultUserDetails = mysqli_query($con,$sqlGetUserDetails);
		while ($row = $resultUserDetails->fetch_assoc()){
			$userName = $row['userName'];
			$userPhoneNumber = $row['userPhoneNumber'];
			$userEmail = $row['userEmail'];
		}

		$sql = "SELECT * FROM userBookings
						WHERE userBookingID=$userBookingID AND userID=$userID AND bookingVenue='$businessName'";
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

		if (mysqli_num_rows($result) > 0) {
			if ($bookingIsCancelled==1) {
				$isFound = true;
				$isValid = false;
				$statusMessage = "<b>INVALID BOOKING</b><br><br><tt><b><font color='red'><span class='fa fa-times fa-lg'></span><br>Booking Cancelled By Customer On<br>$bookingIsCancelledTimeStamp</font></b></tt><br><br>";
			}
			else {
				if ($bookingDate==date("Y-m-d")) {
					$statusMessage = "<b>VALID BOOKING</b><br><br><tt><b>$bookingDate $bookingStartTime to $bookingEndTime<br>$bookingCategory<br>Court $bookingFacilityNo</b><br>User Booking ID: $userBookingID</tt><br><br>";
					$isFound = true;
					$isValid = true;
				}
				else {
					$isFound = true;
					$isValid = false;
					$statusMessage = "<b>INVALID BOOKING</b><br><br><tt><b>Booking Date is not today.<br>Please check booking receipt for more information.</b></tt><br><br>";
				}
			}
		}
		else {
			$statusMessage = "<b>RECORD NOT FOUND</b><br><br><tt><b>Please check booking receipt to ensure that you are at the correct venue or contact customer service.</b></tt><br><br>";
			$isFound = false;
		}
	}

	else {
		$isEmpty = true;
		$statusMessage = "<b>POINT QR CODE AT CAMERA TO VERIFY BOOKING</b><br><br>";
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
		<title>ASport for Business | Entrance Verification</title>
		<?php
		include('includes/business-head-styles.php');
		?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Entrance Verification');
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
					<li class="active">Entrance Verification</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Entrance Verification</div>
					</div>
				</div>
			</div>

      <div class="row">
  			<div class="col-md-6">
  				<div class="panel panel-default">
  					<div class="panel-body">

							<h3 align="center"><b><span class="fa fa-qrcode"></span><br>QR Scanner</b></h3><br>

							<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

							<div class="col-sm-12">
								<video id="preview" class="p-1 border" style="width:100%;"></video>
								<br><br>
							</div>

							<script type="text/javascript">
								var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 15, mirror: false });
								scanner.addListener('scan',function(content){
									//confirm("QR code detected. Press OK for status check.");
									window.location.href="business-entranceVerification.php?"+content;
								});
								Instascan.Camera.getCameras().then(function (cameras){
									if(cameras.length>0){
										scanner.start(cameras[0]);
										$('[name="options"]').on('change',function(){
											if($(this).val()==1){
												if(cameras[0]!=""){
													scanner.start(cameras[0]);
												}else{
													alert('No main camera found!');
												}
											}else if($(this).val()==2){
												if(cameras[1]!=""){
													scanner.start(cameras[1]);
												}else{
													alert('No secondary camera found!');
												}
											}
										});
									}else{
										console.error('No cameras found.');
										alert('No cameras found.');
									}
								}).catch(function(e){
									console.error(e);
									alert(e);
								});
							</script>

							<div align="center" class="form-group has-success" data-toggle="buttons">
								<label class="btn btn-primary active">
									<input type="radio" name="options" value="1" autocomplete="off" checked> <b>Primary Camera</b>
								</label>
								<label class="btn btn-default">
									<input type="radio" name="options" value="2" autocomplete="off"> <b>Secondary Camera</b>
								</label>
							</div>

  					</div><!-- /.panel-body-->
  				</div><!-- /.panel-->

  			</div><!-- /.col-->

				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b><span class="fa fa-thumbs-up"></span><br>Status Check</b></h3><br>
							<center>
								<?php if ($isEmpty==true): ?>
									<img src="images/qrScanner.png" width="80%"><br><br>
								<?php else: ?>
									<?php if ($isFound==true && $isValid==true): ?>
										<img src="images/tick.png" width="200" height="200"><br><br>
									<?php endif; ?>
									<?php if ($isFound==true && $isValid==false): ?>
										<img src="images/warning.png" width="200" height="200"><br><br>
									<?php endif; ?>
									<?php if ($isFound==false): ?>
										<img src="images/cross.png" width="200" height="200"><br><br>
									<?php endif; ?>
								<?php endif; ?>
								<h3><?php echo $statusMessage ?></h3>
							</center>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div>

			</div>

			<?php if ($isFound==true): ?>

			<div class="row">

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-id-card"></span><br>Customer Information</b></h3>
							<br><br>
							<h3><tt><span class="fa fa-info"></span>&nbspName :<br><b><?php echo $userName ?></tt></b></h3>
							<h3><tt><span class="fa fa-phone"></span>&nbspPhone Number :<br><b><?php echo $userPhoneNumber ?></tt></b></h3>
							<h3><tt><span class="fa fa-envelope-o"></span>&nbspEmail :<br><b><?php echo $userEmail ?></tt></b></h3>
							<br><br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-info-circle"></span><br>Booking Information</b></h3>
							<br>
							<h3><tt><b><span class="fa fa-calendar"></span>&nbsp<?php echo $bookingDate ?></b></tt></h3>
							<h3><tt><b><span class="fa fa-clock-o"></span>&nbsp<?php echo $bookingStartTime ?> - <?php echo $bookingEndTime ?></b></tt></h3>
							<h3><tt><b><span class="fa fa-clock-o"></span>&nbsp<?php echo $bookingDuration ?> hour(s)</b></tt></h3>
							<h3><tt><span class="fa fa-id-card-o"></span>&nbspBooking ID :<b> <?php echo $userBookingID ?></b></tt></h3>
							<h3><tt><span class="fa fa-history"></span>&nbspBooked On :<br><b><?php echo $bookingTransactionTimeStamp ?></b></tt></h3>
							<br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-map"></span><br>Facility Information</b></h3>
							<br><img src="images/<?php echo $bookingCategory ?>.png" width="200" height="190">
							<h3><b><tt><?php echo $bookingCategory ?></tt></b></h3>
							<h3><b><tt>Court <?php echo $bookingFacilityNo ?></tt></b></h3>
							<br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

  		</div><!-- /.row -->

			<?php endif; ?>


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
