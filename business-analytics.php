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
?>

	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport for Business | Analytics</title>
		<?php
		include('includes/business-head-styles.php');
		?>
	</head>


	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Analytics');
		include_once('includes/business-header.php');
		include_once('includes/business-sidebar.php');
		?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="business-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Analytics</li>
				</ol>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Analytics</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-teal">
						<div class="panel-heading"><center>THIS WEEK</center></div>
						<div class="panel-heading"><center>06 NOVEMBER to 12 NOVEMBER 2022</center></div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-ticket"></span><br>Total Bookings</b></h3>
							<div class="easypiechart" id="easypiechart-teal" data-percent="100" >
								<span class="percent"><b>58</b></span>
							</div>
							<h3><b><span class="fa fa-money"></span><br>Total Sales</b></h3>
							<h3 class="color-teal"><b>RM1380</b></h3>
							<h3><b><span class="fa fa-gift"></span><br>Total Loyalty Points Issued</b></h3>
							<h3 class="color-teal"><b>1380</b></h3>
							<br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-pie-chart"></span><br>Bookings Category Analysis</b></h3>
							<br>
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<div id="categoryPieChartThisWeek" style="height: 370px; width: 100%;"></div><br><br>
							</div>
							<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-bar-chart"></span><br>Total Bookings Analysis<br></h3><br>
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<div id="barChartBookingsThisWeek" style="height: 370px; width: 100%;"></div><br><br>
							</div>
							<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-line-chart"></span><br>Total Sales Analysis<br></b></h3><br>
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<div id="lineGraphSalesThisWeek" style="height: 370px; width: 100%;"></div><br><br>
							</div>
							<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

				<div class="col-md-6">
					<div class="panel panel-orange">
						<div class="panel-heading"><center>THIS MONTH</center></div>
						<div class="panel-heading"><center>NOVEMBER 2022</center></div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-ticket"></span><br>Total Bookings</b></h3>
							<div class="easypiechart" id="easypiechart-orange" data-percent="100" >
								<span class="percent"><b>190</b></span>
							</div>
							<h3><b><span class="fa fa-money"></span><br>Total Sales</b></h3>
							<h3 class="color-orange"><b>RM2520</b></h3>
							<h3><b><span class="fa fa-gift"></span><br>Total Loyalty Points Issued</b></h3>
							<h3 class="color-orange"><b>2520</b></h3>
							<br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-pie-chart"></span><br>Bookings Category Analysis</b></h3>
							<br>
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<div id="categoryPieChartThisMonth" style="height: 370px; width: 100%;"></div><br><br>
							</div>
							<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-bar-chart"></span><br>Total Bookings Analysis<br></h3><br>
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<div id="barChartBookingsThisMonth" style="height: 370px; width: 100%;"></div><br><br>
							</div>
							<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-line-chart"></span><br>Total Sales Analysis<br></b></h3><br>
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<div id="lineGraphSalesThisMonth" style="height: 370px; width: 100%;"></div><br><br>
							</div>
							<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->



			</div>

			<?php include_once('includes/footer.php'); ?>

		</div>

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
								{ label: "Badminton", y: 22 },
								{ label: "Basketball", y: 11 },
								{ label: "Football", y: 6 },
								{ label: "Futsal", y: 5 },
								{ label: "Squash", y: 5 },
								{ label: "Tennis", y: 9 },
								{ label: "Others", y: 0 }
							]
					}]
				};
				$("#categoryPieChartThisWeek").CanvasJSChart(categoryPieChartThisWeek);

				var categoryPieChartThisMonth = {
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
								{ label: "Badminton", y: 80 },
								{ label: "Basketball", y: 35 },
								{ label: "Football", y: 10 },
								{ label: "Futsal", y: 10 },
								{ label: "Squash", y: 25 },
								{ label: "Tennis", y: 30 },
								{ label: "Others", y: 0 }
							]
					}]
				};
				$("#categoryPieChartThisMonth").CanvasJSChart(categoryPieChartThisMonth);

				var barChartBookingsThisWeek = {
					title: {
						text: ""
					},
					axisY:{
						title:"Total No Of Bookings"
					},
					axisX:{
						title:"Date"
					},
					data: [
					{
						// Change type to "doughnut", "line", "splineArea", etc.
						type: "column",
						dataPoints: [
							{ label: "Sunday",  y: 13  },
							{ label: "Monday", y: 10  },
							{ label: "Tuesday", y: 5  },
							{ label: "Wednesday",  y: 4  },
							{ label: "Thursday",  y: 6  },
							{ label: "Friday",  y: 9  },
							{ label: "Saturday",  y: 11  }
						]
					}
					]
				};
				$("#barChartBookingsThisWeek").CanvasJSChart(barChartBookingsThisWeek);

				var barChartBookingsThisMonth = {
					title: {
						text: ""
					},
					axisY:{
						title:"Total No Of Bookings"
					},
					axisX:{
						title:"Date"
					},
					data: [
					{
						// Change type to "doughnut", "line", "splineArea", etc.
						type: "column",
						dataPoints: [
							{ label: "Week 1",  y: 110 },
							{ label: "Week 2", y: 60 },
							{ label: "Week 3", y: 20 },
							{ label: "Week 4",  y: 0 },
							{ label: "Week 5",  y: 0 }
						]
					}
					]
				};
				$("#barChartBookingsThisMonth").CanvasJSChart(barChartBookingsThisMonth);

				var lineGraphSalesThisWeek = {
					animationEnabled: true,
					title:{
						text: ""
					},
					axisX: {
						title: "Date",
						valueFormatString: "DD MMM"
					},
					axisY: {
						title: "Total Sales (RM)",
						//prefix: "RM"
					},
					data: [{
						yValueFormatString: "$#,###",
						xValueFormatString: "DD MMM, YYYY",
						type: "spline",
						dataPoints: [
							{ x: new Date(2022, 10, 1), y: 250 },
							{ x: new Date(2022, 10, 2), y: 180 },
							{ x: new Date(2022, 10, 3), y: 150 },
							{ x: new Date(2022, 10, 4), y: 190 },
							{ x: new Date(2022, 10, 5), y: 300 },
							{ x: new Date(2022, 10, 6), y: 500 },
							{ x: new Date(2022, 10, 7), y: 300 },
						]
					}]
				};
				$("#lineGraphSalesThisWeek").CanvasJSChart(lineGraphSalesThisWeek);

				var lineGraphSalesThisMonth = {
					animationEnabled: true,
					title:{
						text: ""
					},
					axisX: {
						title: "Date",
						valueFormatString: "DD MMM"
					},
					axisY: {
						title: "Total Sales (RM)",
						//prefix: "RM"
					},
					data: [{
						yValueFormatString: "$#,###",
						xValueFormatString: "DD MMM, YYYY",
						type: "spline",
						dataPoints: [
							{ x: new Date(2022, 10, 5), y: 1120 },
							{ x: new Date(2022, 10, 12), y: 720 },
							{ x: new Date(2022, 10, 19), y: 680 },
							{ x: new Date(2022, 10, 26), y: 0 },
							{ x: new Date(2022, 10, 30), y: 0 },
						]
					}]
				};
				$("#lineGraphSalesThisMonth").CanvasJSChart(lineGraphSalesThisMonth);

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
