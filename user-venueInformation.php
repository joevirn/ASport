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
	$businessID = $_GET['businessID'];

	//OBTAIN BUSINESS VENUE NAME
	$sql = "SELECT * FROM business
					WHERE businessID=$businessID";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$businessName = $data['businessName'];
	}

	//GET EXISTING COVER IMAGE FILE NAME
	$sql = "SELECT * FROM businessVenueManagement
					WHERE businessID=$businessID";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$coverImageFileName = $data['coverImageFileName'];
	}

	//OBTAIN VENUE MANAGEMENT INFORMATION
	$sql = "SELECT * FROM businessVenueManagement
					WHERE businessID=$businessID";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$aboutUsLine1 = $data['aboutUsLine1'];
		$aboutUsLine2 = $data['aboutUsLine2'];
		$aboutUsLine3 = $data['aboutUsLine3'];
		$aboutUsLine4 = $data['aboutUsLine4'];
		$aboutUsLine5 = $data['aboutUsLine5'];
		$businessPhoneNumber = $data['businessPhoneNumber'];
		$businessEmail = $data['businessEmail'];
		$facebookLink = $data['facebookLink'];
		$twitterLink = $data['twitterLink'];
		$instagramLink = $data['instagramLink'];
		$youtubeLink = $data['youtubeLink'];
		$locationAddressLine1 = $data['locationAddressLine1'];
		$locationAddressLine2 = $data['locationAddressLine2'];
		$locationCity = $data['locationCity'];
		$locationState = $data['locationState'];
		$locationPostcode = $data['locationPostcode'];
	}

	//ADDRESS STRING FOR GOOGLE MAPS
	$address = "$locationAddressLine1 $locationAddressLine2 $locationPostcode $locationCity $locationState";
?>

	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport | Venue Information</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
		<link href="css/owl.carousel.min.css" rel="stylesheet">
		<link href="css/owl.theme.default.min.css" rel="stylesheet">
		<style type="text/css">
			/* FOR IMG */
			img {
			  transition: 0.8s;
				border-radius: 3;
			}
			/* img:hover {
				transform: rotate(360deg);
			} */

			/* FOR IMAGE CAROUSEL */

			* {box-sizing: border-box}

			/* Container needed to position the overlay. Adjust the width as needed */
			.container {
			  position: relative;
				width: auto;
			}

			/* Make the image to responsive */
			.image {
			  display: block;
			  width: 100%;
			  height: auto;
			}

			/* The overlay effect - lays on top of the container and over the image */
			.overlay {
			  position: absolute;
			  bottom: 0;
			  background: rgb(0, 0, 0);
			  background: rgba(0, 0, 0, 0.5); /* Black see-through */
			  color: #f1f1f1;
			  width: 96.4%;
			  transition: .5s ease;
			  opacity:0;
			  color: white;
			  font-size: 15px;
			  padding: 15px;
			  text-align: center;
			}

			/* When you mouse over the container, fade in the overlay title */
			.container:hover .overlay {
			  opacity: 1;
			}
		</style>
	</head>

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'New Booking');
		include_once('includes/user-header.php');
		include_once('includes/user-sidebar.php');
		?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="user-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Venue Information</li>
				</ol>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading"><?php echo $businessName ?></div>
					</div>
				</div>
			</div>

			<?php if ($coverImageFileName): ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<img src="<?php echo $coverImageFileName ?>" width="100%" height="400">
						</div><!-- /.panel-->
					</div><!-- /.col-->
				</div><!-- /.row -->
			<?php endif; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<img src="images/address.png" width="50" height="50"></p<br>
							<h3><b>Address :</b><br><br><tt><?php echo "$locationAddressLine1<br>$locationAddressLine2<br>$locationPostcode $locationCity<br>$locationState"; ?></tt></h3><br>
							<iframe src="https://www.google.com/maps?q=<?php echo $businessName . ' ' . $address; ?>&output=embed" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<p><img src="images/phone.png" width="50" height="50"></p>
							<h3><b>Phone :</b><br><br><tt><?php echo $businessPhoneNumber ?></tt></h3><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<a href="mailto:<?php echo $businessEmail ?>">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br><br>
								<p><img src="images/email.png" width="50" height="50"></p>
								<h3><b>Email :</b><br><br><tt><?php echo $businessEmail ?></tt></h3><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-3">
					<a href="http://<?php echo $facebookLink ?>" target="_blank">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Facebook</b></h4><br>
								<p><img src="images/facebook.png" width="100" height="100"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-3">
					<a href="http://<?php echo $twitterLink ?>" target="_blank">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Twitter</b></h4><br>
								<p><img src="images/twitter.png" width="100" height="100"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-3">
					<a href="http://<?php echo $instagramLink ?>" target="_blank">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Instagram</b></h4><br>
								<p><img src="images/instagram.png" width="100" height="100"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-3">
					<a href="http://<?php echo $youtubeLink ?>" target="_blank">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>Youtube</b></h4><br>
								<p><img src="images/youtube.png" width="100" height="100"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<br><br>
							<img src="images/gallery.png" width="50" height="50"></p<br>
							<h3><b>Photo Gallery</b></h3><br>
							<div class="owl-carousel owl-theme">
								<?php
								//OBTAIN IMAGE FILE PATH
								$sql = "SELECT * FROM businessVenueGallery
												WHERE businessID=$businessID";
								$result = mysqli_query($con,$sql);
								while ($data = $result->fetch_assoc()){
									$imageFileName = $data['imageFileName'];
									$imageDescription = $data['imageDescription'];
									//DISPLAY IMAGE CAROUSEL
								?>
									<div class="container">
										<div class="item" data-merge="3"><img src="<?php echo $imageFileName ?>" width="100%" height="450"></div>
										<div class="overlay">
											<div class="text"><?php echo $imageDescription ?></div>
										</div>
									</div>
								<?php
								}
								?>
							</div>
							<?php if ($imageFileName==NULL): ?>
								<center><img src="images/icon-noImageAvailable.png" width="25%" height="25%"></center><br>
							<?php endif; ?>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<a href="http://<?php echo $youtubeLink ?>" target="_blank">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br><br>
								<img src="images/info.png" width="50" height="50"></p<br>
								<h3><b>About Us</b></h3><br>
								<div class="col-md-1"></div>
								<div class="col-md-10">
									<h3>
										<tt>
										<?php echo $aboutUsLine1 ?><br>
										<?php echo $aboutUsLine2 ?><br>
										<?php echo $aboutUsLine3 ?><br>
										<?php echo $aboutUsLine4 ?><br>
										<?php echo $aboutUsLine5 ?><br>
										</tt>
									</h3>
								</div>
								<div class="col-md-1"></div>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
			</div><!-- /.row-->

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

  	<script src="js/jquery-3.6.0.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.owl-carousel').owlCarousel({
					items:1,
					loop:true,
					margin:10,
					center:true,
					autoWidth:true,
					autoHeight:true,
					nav:true,
					autoplay:true,
					autoplayTimeout:5000,
					autoplayHoverPause:true
				})
			});
		</script>

		<!--javascript source-->
		<!-- <script src="js/jquery-1.11.1.min.js"></script> -->
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
