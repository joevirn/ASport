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
		<title>ASport | Terms and Conditions</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Terms and Conditions');
		include_once('includes/user-header.php');
		include_once('includes/user-sidebar.php');
		?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="user-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Help Centre -> Terms and Conditions</li>
				</ol>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Terms and Conditions</div>
					</div>
				</div>
			</div>

      <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<p><img src="images/voucher.png" width="60" height="60"></p>
							<h3><b><tt>Loyalty Rewards Voucher</tt><br>Terms and Conditions</b></h3>
							<br>
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<h4>
								<ul>
									<li>Each voucher is valid for one-time use only.</li><br>
									<li>Voucher is non-transferable, non-refundable and non-exchangeable.</li><br>
									<li>Users can retrieve all redeemed vouchers from Loyalty -> Rewards.</li><br>
									<li>ASport reserves the right to vary and amend these terms and conditions at any time without prior notice.</li><br>
									<li>ASport reserves the sole and absolute right to alter or end this promotion, without giving prior notice, or compensation in cash or any kind.</li><br>
								</ul>
								</h4>
							</div>
							<div class="col-md-1"></div>
							<br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<p><img src="images/tnc.png" width="50" height="50"></p>
							<h3><b><tt>General</tt><br>Terms and Conditions</b></h3><br>
							<center>
								<a href="documents/sample-tnc.pdf" target="_blank" class="btn btn-primary"><b><i class="fa fa-search fa-lg"></i>&nbsp VIEW PDF</b></a>
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
