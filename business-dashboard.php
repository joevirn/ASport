<<?php
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
?>

	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ASport for Business | Dashboard</title>
		<?php
		include('includes/business-head-styles.php');
		?>
	</head>

	<body>
		<?php
		define('PAGE', 'Dashboard');
		include_once('includes/business-header.php');
		include_once('includes/business-sidebar.php');
		?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

			<!-- <div class="row">
				<ol class="breadcrumb">
					<li><a href="business-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Dashboard</li>
				</ol>
			</div> -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Dashboard</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-teal">
						<div class="panel-heading"><center>TODAY ( <?php echo date("l - d/m/y") ?> )</center></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-ticket"></span><br>Total Bookings</b></h3>
								<div class="easypiechart" id="easypiechart-teal" data-percent="100" >
									<span class="percent"><b>10</b></span>
								</div>
								<a href="business-bookingsManagement-upcoming.php"><button class="btn bg-teal" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW DETAILS</b></button></a>
								&nbsp &nbsp
								<a href="business-entranceVerification.php"><button class="btn bg-teal" ><i class="fa fa-qrcode fa-lg"></i><b>&nbsp ENTRANCE VERIFICATION</b></button></a>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br>
								<h3><b><span class="fa fa-money"></span><br>Total<br>Sales</b></h3><br>
								<h3 class="color-teal"><b>RM1380</b></h3>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br>
								<h3><b><span class="fa fa-star"></span><br>Total<br>Loyalty Points</b></h3><br>
								<h3 class="color-teal"><b>1380</b></h3>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-pie-chart"></span><br>Bookings Category<br>Analysis</b></h3>
								<br>
								<div class="col-md-1"></div>
								<div class="col-md-10">
									<div id="categoryPieChartToday" style="height: 370px; width: 100%;"></div><br><br>
								</div>
								<div class="col-md-1"></div>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
				</div><!-- /.col-->
			</div><!-- /.row-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-orange">
						<div class="panel-heading"><center>ALL UPCOMING</center></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-ticket"></span><br>Total Bookings</b></h3>
								<div class="easypiechart" id="easypiechart-orange" data-percent="100" >
									<span class="percent"><b>36</b></span>
								</div>
								<a href="business-bookingsManagement-upcoming.php"><button class="btn bg-orange" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW DETAILS</b></button></a>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br>
								<h3><b><span class="fa fa-money"></span><br>Total<br>Sales</b></h3><br>
								<h3 class="color-orange"><b>RM2360</b></h3>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br>
								<h3><b><span class="fa fa-star"></span><br>Total<br>Loyalty Points</b></h3><br>
								<h3 class="color-orange"><b>2360</b></h3>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-pie-chart"></span><br>Bookings Category<br>Analysis</b></h3>
								<br>
								<div class="col-md-1"></div>
								<div class="col-md-10">
									<div id="categoryPieChartAllUpcoming" style="height: 370px; width: 100%;"></div><br><br>
								</div>
								<div class="col-md-1"></div>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
				</div><!-- /.col-->
			</div><!-- /.row-->

			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

		<script type="text/javascript">
			window.onload = function() {

				var categoryPieChartThisWeek = {
					title: {
						text: ""
					},
					data: [{
							type: "pie",
							startAngle: 45,
							showInLegend: "true",
							legendText: "{label}",
							indexLabel: "{label} ({y})",
							yValueFormatString:"#,##0.#"%"",
							dataPoints: [
								{ label: "Badminton", y: 6 },
								{ label: "Basketball", y: 2 },
								{ label: "Football", y: 0 },
								{ label: "Futsal", y: 0 },
								{ label: "Squash", y: 0 },
								{ label: "Tennis", y: 3 }
							]
					}]
				};
				$("#categoryPieChartToday").CanvasJSChart(categoryPieChartThisWeek);

				var categoryPieChartAllUpcoming = {
					title: {
						text: ""
					},
					data: [{
							type: "pie",
							startAngle: 45,
							showInLegend: "true",
							legendText: "{label}",
							indexLabel: "{label} ({y})",
							yValueFormatString:"#,##0.#"%"",
							dataPoints: [
								{ label: "Badminton", y: 20 },
								{ label: "Basketball", y: 5 },
								{ label: "Football", y: 0 },
								{ label: "Futsal", y: 0 },
								{ label: "Squash", y: 6 },
								{ label: "Tennis", y: 5 }
							]
					}]
				};
				$("#categoryPieChartAllUpcoming").CanvasJSChart(categoryPieChartAllUpcoming);


			}
		</script>

		<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

		<!--javascript source-->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>
		<script src="js/chart-data.js"></script>
		<script src="js/easypiechart.js"></script>
		<script src="js/easypiechart-data.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="js/custom.js"></script>

		</body>
		<!--end of body-->

		</html>
		<!--end of html-->

		<?php
		}
		?>
