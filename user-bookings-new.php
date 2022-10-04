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
		<title>ASport | New Booking</title>
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
						<div class="panel-heading">New Booking</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Badminton</b></h4>
								<p>
									<a href="user-bookings-new-badminton.php">
										<img src="images/badminton.png" width="200" height="200">
									</a>
								</p>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Basketball</b></h4>
								<p>
									<a href="user-bookings-new-basketball.php">
										<img src="images/basketball.png" width="200" height="200">
									</a>
								</p>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Football</b></h4>
								<p>
									<a href="user-bookings-new-football.php">
										<img src="images/football.png" width="200" height="200">
									</a>
								</p>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row-->

			<div class="row">
				<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Futsal</b></h4>
								<p>
									<a href="user-bookings-new-futsal.php">
										<img src="images/futsal.png" width="200" height="200">
									</a>
								</p>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Squash</b></h4>
								<p>
									<a href="user-bookings-new-squash.php">
										<img src="images/squash.png" width="200" height="200">
									</a>
								</p>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Tennis</b></h4>
								<p>
									<a href="user-bookings-new-tennis.php">
										<img src="images/tennis.png" width="200" height="200">
									</a>
								</p>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
				</div><!-- /.col-->
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
