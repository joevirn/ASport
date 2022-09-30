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
		<title>ASport | Upcoming Bookings</title>
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
					<li class="active">My Bookings -> Upcoming</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Upcoming Bookings</div>
					</div>
				</div>
			</div>

      <div class="row">
  			<div class="col-md-12">
  				<div class="panel panel-default">
  					<div class="panel-body">


              <div class="col-md-2"></div>

              <div class="col-md-8">

              <h4>
                <table align="center" style="width: 100%;">
                <tr>
                  <th>QR Code</th>
                  <td>
                    <canvas id="qr-code"></canvas>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

                    <script>
                      /* JS comes here */
                      var qr;
                      (function() {
                                    qr = new QRious({
                                    element: document.getElementById('qr-code'),
                                    size: 200,
                                    value: 'BRC00001'
                                });
                            })();
                    </script>

                  </td>
                <tr>
                <tr>
                  <th>Booking ID:</th>
                  <td>BRC00001</th>
                </tr>
                <tr>
                  <th>Venue:</th>
                  <td>Relau Sports Complex</th>
                </tr>
                <tr>
                  <th>Facility Type:</th>
                  <td>Badminton</th>
                </tr>
                <tr>
                  <th>Date:</th>
                  <td>28 September 2022</th>
                </tr>
                <tr>
                  <th>Start Time:</th>
                  <td>10AM</th>
                </tr>
                <tr>
                  <th>End Time:</th>
                  <td>12PM</th>
                </tr>
                <tr>
                  <th>Duration:</th>
                  <td>1 HOUR</th>
                </tr>
                </table>
              </h4>


              </div>

              <div class="col-md-2"></div>

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
