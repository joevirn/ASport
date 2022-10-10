<!-- <?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the user id in the session is being cleared, log out the user
if (strlen($_SESSION['detsuid'] == 0)) {
	header('location:user-logout.php');
} else {
?> -->

	<!DOCTYPE html>
	<!--start of html-->
	<html>

	<!--start of head-->

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport | New Booking - Relau Sports Complex</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<link rel="icon" type="image/png" href="images/ASport.png" sizes="113x113" >

		<!--Custom Font-->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

		<style>
			table {
			  font-family: arial, sans-serif;
			  border-collapse: collapse;
			  width: 100%;
			}
			td, th {
			  border: 1px solid #dddddd;
				text-align: center;
			  padding: 8px;
			}
			.available {
				background-color: white;
			}
			.booked {
				background-color: lightgray;
			}
			.locked {
				background-color: gray;
			}
			.selected {
				background-color: mediumseagreen;
			}
		</style>
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
					<li class="active">New Booking -> Badminton -> Relau Sports Complex</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Relau Sports Complex</div>
					</div>
				</div>
			</div>

			<div class="row">

				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-body">
	            <h3 align="center"><b>Booking Receipt</b></h3>
	            <form role="form" method="post" action="">
	              <div class="col-md-1"></div>
	  						<div class="col-md-10">
									<div class="form-group">
										<label><span class="fa fa-id-card-o"></span>&nbsp Booking ID</label>
										<p class="form-control" type="text" name="bookingID"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-calendar"></span>&nbsp Date</label>
										<p class="form-control" type="text" name="bookingDate"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Start Time</label>
										<p class="form-control" type="text" name="bookingStartTime"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp End Time</label>
										<p class="form-control" type="text" name="bookingEndTime"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-list"></span>&nbsp Duration</label>
										<p class="form-control" type="text" name="bookingDuration"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-location-arrow"></span>&nbsp Venue</label>
										<p class="form-control" type="text" name="bookingVenue"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-th-large"></span>&nbsp Category</label>
										<p class="form-control" type="text" name="bookingCategory"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-info-circle"></span>&nbsp Facility No</label>
										<p class="form-control" type="text" name="bookingFacilityNo"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price (RM)</label>
										<p class="form-control" type="text" name="bookingPrice"></p>
									</div>
									<div class="form-group">
										<label><span class="fa fa-calendar-minus-o"></span>&nbsp Transaction Date & Time</label>
										<p class="form-control" type="text" name="bookingTransactionDate"></p>
									</div>
									<?php
										if($msg){
											echo "<p style='color:red;'>";
											echo $msg;
											echo "</p>";
										}
									?>
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

	  					</form>

						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->


				<div class="col-md-5">
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
											value: 'BRC00001'
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
							<h3><b>Facility Information</b></h3>
								<table>
									<tr>
										<td style="border:none; text-align:right;" width="55%"><img src="images/badminton.png" width="200" height="200"></td>
										<td style="border:none; text-align:left;" width="45%">
											<h4><b>Badminton</b></h4>
											<h4><b>Court 1</b></h4>
										</td>
									</tr>
								</table>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Venue Information</b></h3>
							<p><img src="images/facilities-relausportscomplex.png" width="100%" height="250"></p>
							<h4><b>Relau Sports Complex</b></h4>
							<h5><b>Bayan Lepas, Penang</b></h5>
							<p>
								<a href="" class="btn btn-default" style="width: 35%;">View Venue Details</a>
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
