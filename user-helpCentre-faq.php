<?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the user id in the session is being cleared, log out the user
if (strlen($_SESSION['ASportUserSessionCounter'] == 0)) {
	header('location:user-logout.php');
} else {
?>

	<!DOCTYPE html>
	<!--start of html-->
	<html>

	<!--start of head-->

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport | Frequenty Asked Questions</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Frequently Asked Questions');
		include_once('includes/user-header.php');
		include_once('includes/user-sidebar.php');
		?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="user-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Help Centre -> Frequently Asked Questions</li>
				</ol>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Frequently Asked Questions</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<div style="margin-left:20px; margin-right:20px;">
								<br><br>
								<p><img src="images/number-1.png" width="50" height="50"></p>
								<h3><b><tt>Booking</tt><br>How early can I book in advance?</b></h3>
								<h4><tt>Bookings can be made earliest 2 weeks (14 days) before the booking date.</tt></h4>
								<br>
							</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<div style="margin-left:20px; margin-right:20px;">
								<br><br>
								<p><img src="images/number-2.png" width="50" height="50"></p>
								<h3><b><tt>Cancellation</tt><br>Are cancellation of bookings allowed?</b></h3>
								<h4><tt>Yes, cancellation can be done via the booking receipt page.</tt></h4>
								<br>
							</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<div style="margin-left:20px; margin-right:20px;">
								<br><br>
								<p><img src="images/number-3.png" width="50" height="50"></p>
								<h3><b><tt>Cancellation</tt><br>Can I cancel my booking at any time?</b></h3>
								<h4><tt>Cancellation must be made at least 1 day before the booking date.</tt></h4>
								<br>
							</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<div style="margin-left:20px; margin-right:20px;">
								<br><br>
								<p><img src="images/number-4.png" width="50" height="50"></p>
								<h3><b><tt>Loyalty</tt><br>How are loyalty points awarded?</b></h3>
								<h4><tt>Loyalty points are awarded for every successful booking with RM1 equivalent to 1 point.</tt></h4>
								<br>
							</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<div style="margin-left:20px; margin-right:20px;">
								<br><br>
								<p><img src="images/number-5.png" width="50" height="50"></p>
								<h3><b><tt>Loyalty</tt><br>How are loyalty points deducted?</b></h3>
								<h4><tt>Loyalty points are deducted accordingly when a booking is cancelled or a loyalty rewards voucher is redeemed.</tt></h4>
								<br>
							</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<p><img src="images/faq.png" width="50" height="50"></p>
							<h3><b><tt>View All</tt><br>Frequently Asked Questions</b></h3><br>
							<center>
								<a href="documents/sample-faq.pdf" target="_blank" class="btn btn-primary"><b><i class="fa fa-search fa-lg"></i>&nbsp VIEW PDF</b></a>
							</center>
							<br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
  		</div><!-- /.row -->

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
