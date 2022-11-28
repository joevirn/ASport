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
		<title>ASport | Contact Us</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Contact Us');
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
					<li class="active">Help Centre -> Contact Us</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Contact Us</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<p><img src="images/ASport.png" width="180" height="180"></p>
							<h1><b><tt>ASport</tt></b></h1><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<p><img src="images/address.png" width="50" height="50"></p>
							<h3><b>Address :</b><br><br><tt>1-Z, Lebuh Bukit Jambul, Bukit Jambul, 11900 Bayan Lepas, Penang</tt></h3><br>
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.4919888048717!2d100.27739139687176!3d5.341603783770761!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304ac048a161f277%3A0x881c46d428b3162c!2sINTI%20International%20College%20Penang!5e0!3m2!1sen!2smy!4v1669489555496!5m2!1sen!2smy" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<p><img src="images/phone.png" width="50" height="50"></p>
							<h3><b>Phone :</b><br><br><tt>+60 18 472 3128</tt></h3><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<a href="mailto:info@asport.com">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br><br>
								<p><img src="images/email.png" width="50" height="50"></p>
								<h3><b>Email :</b><br><br><tt>info@asport.com</tt></h3><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-4">
					<a href="http://www.facebook.com" target="_blank">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Facebook</b></h4><br>
								<p><img src="images/facebook.png" width="100" height="100"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-4">
					<a href="http://www.twitter.com" target="_blank">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Twitter</b></h4><br>
								<p><img src="images/twitter.png" width="100" height="100"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-4">
					<a href="http://www.instagram.com" target="_blank">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Instagram</b></h4><br>
								<p><img src="images/instagram.png" width="100" height="100"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
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
