<!-- <?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the user id in the session is being cleared, log out the user
if (strlen($_SESSION['ASportBusinessSessionCounter'] == 0)) {
	header('location:business-logout.php');
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
					<li><a href="dashboard.php">
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

							<h3 align="center"><b>QR Scanner</b></h3><br>

							<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

							<div class="col-sm-12">
								<video id="preview" class="p-1 border" style="width:100%;"></video>
								<br><br>
							</div>

							<script type="text/javascript">
								var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
								scanner.addListener('scan',function(content){
									alert(content);
									//window.location.href=content;
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
								<input type="radio" name="options" value="1" autocomplete="off" checked> Primary Camera
								</label>
								<label class="btn btn-secondary">
								<input type="radio" name="options" value="2" autocomplete="off"> Secondary Camera
								</label>
							</div>

  					</div><!-- /.panel-body-->
  				</div><!-- /.panel-->
  			</div><!-- /.col-->

				<div class="col-md-6">
  				<div class="panel panel-default">
  					<div class="panel-body">

							<h3 align="center"><b>Status Check</b></h3><br>

  					</div><!-- /.panel-body-->
  				</div><!-- /.panel-->
  			</div><!-- /.col-->

				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">

							<h3 align="center"><b>Booking Information</b></h3><br>

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
