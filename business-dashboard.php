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
	$businessID = $_SESSION['ASportBusinessSessionCounter'];

	//GET BUSINESS NAME
	$sql = "SELECT businessName FROM business WHERE businessID=$businessID";
	$result = mysqli_query($con,$sql);
	while ($row = $result->fetch_assoc()){
		$businessName = $row['businessName'];
	}

	//TODAY
	//GET COUNT FOR TODAY'S TOTAL BOOKINGS AND TOTAL SALES AND BOOKINGS CATEGORY PIE CHART
	$sqlToday1 = "SELECT * FROM userBookings WHERE bookingVenue='$businessName' AND bookingIsCancelled IS NULL AND bookingDate=CURDATE()";
	$resultToday1 = mysqli_query($con,$sqlToday1);
	if (mysqli_num_rows($resultToday1) == 0) {
		$todayTotalBookings = 0;
		$todayTotalSales = 0;
		$todayTotalLoyaltyPoints = 0;
	}
	else {
		while ($row = $resultToday1->fetch_assoc()){
			$bookingPrice = $row['bookingPrice'];
			$bookingCategory = $row['bookingCategory'];
			//COUNTER FOR TOTAL BOOKINGS
			$todayTotalSales += $bookingPrice;
			//COUNTER FOR TOTAL BOOKINGS
			$todayTotalBookings++;
			//COUNTER FOR EACH BOOKING CATEGORY FOR PIE CHART
			if ($bookingCategory == "Badminton") {
				$todayTotalBadminton++;
			}
			elseif ($bookingCategory == "Basketball") {
				$todayTotalBasketball++;
			}
			elseif ($bookingCategory == "Football") {
				$todayTotalFootball++;
			}
			elseif ($bookingCategory == "Futsal") {
				$todayTotalFutsal++;
			}
			elseif ($bookingCategory == "Squash") {
				$todayTotalSquash++;
			}
			elseif ($bookingCategory == "Tennis") {
				$todayTotalTennis++;
			}
			else {
				$todayTotalBadminton = 0;
				$todayTotalBasketball = 0;
				$todayTotalFootball = 0;
				$todayTotalFutsal = 0;
				$todayTotalSquash = 0;
				$todayTotalTennis = 0;
			}
			//GET COUNT FOR TODAY'S TOTAL LOYALTY POINTS
			$userLoyaltyTransactionID = $row['userLoyaltyTransactionID'];
			$sqlToday2 = "SELECT * FROM userLoyaltyTransactions WHERE userLoyaltyTransactionID='$userLoyaltyTransactionID'";
			$resultToday2 = mysqli_query($con,$sqlToday2);
			while ($row = $resultToday2->fetch_assoc()){
				$pointsAddedAmount = $row['pointsAddedAmount'];
				//COUNTER TODAY'S TOTAL LOYALTY POINTS
				$todayTotalLoyaltyPoints += $pointsAddedAmount;
			}
		}
	}

	//ALL UPCOMING
	//GET COUNT FOR ALL UPCOMING TOTAL BOOKINGS AND TOTAL SALES AND BOOKINGS CATEGORY PIE CHART
	$sqlUpcoming1 = "SELECT * FROM userBookings WHERE bookingVenue='$businessName' AND bookingIsCancelled IS NULL AND bookingDate>=CURDATE()";
	$resultUpcoming1 = mysqli_query($con,$sqlUpcoming1);

	if (mysqli_num_rows($resultUpcoming1) == 0) {
		$upcomingTotalBookings = 0;
		$upcomingTotalSales = 0;
		$upcomingTotalLoyaltyPoints = 0;
	}
	else {
		while ($row = $resultUpcoming1->fetch_assoc()){
			$bookingPrice = $row['bookingPrice'];
			$bookingCategory = $row['bookingCategory'];
			//COUNTER FOR TOTAL BOOKINGS
			$upcomingTotalSales += $bookingPrice;
			//COUNTER FOR TOTAL BOOKINGS
			$upcomingTotalBookings++;
			//COUNTER FOR EACH BOOKING CATEGORY FOR PIE CHART
			if ($bookingCategory == "Badminton") {
				$upcomingTotalBadminton++;
			}
			elseif ($bookingCategory == "Basketball") {
				$upcomingTotalBasketball++;
			}
			elseif ($bookingCategory == "Football") {
				$upcomingTotalFootball++;
			}
			elseif ($bookingCategory == "Futsal") {
				$upcomingTotalFutsal++;
			}
			elseif ($bookingCategory == "Squash") {
				$upcomingTotalSquash++;
			}
			elseif ($bookingCategory == "Tennis") {
				$upcomingTotalTennis++;
			}
			else {
				$upcomingTotalBadminton = 0;
				$upcomingTotalBasketball = 0;
				$upcomingTotalFootball = 0;
				$upcomingTotalFutsal = 0;
				$upcomingTotalSquash = 0;
				$upcomingTotalTennis = 0;
			}
			//GET COUNT FOR TOTAL LOYALTY POINTS
			$userLoyaltyTransactionID = $row['userLoyaltyTransactionID'];
			$sqlUpcoming2 = "SELECT * FROM userLoyaltyTransactions WHERE userLoyaltyTransactionID='$userLoyaltyTransactionID'";
			$resultUpcoming2 = mysqli_query($con,$sqlUpcoming2);
			while ($row = $resultUpcoming2->fetch_assoc()){
				$pointsAddedAmount = $row['pointsAddedAmount'];
				//COUNTER TOTAL LOYALTY POINTS
				$upcomingTotalLoyaltyPoints += $pointsAddedAmount;
			}
		}
	}

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
						<div class="panel-heading"><center>TODAY ( <?php echo date("l - Y-m-d") ?> )</center></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-ticket"></span><br>Total Bookings</b></h3>
								<div class="easypiechart" id="easypiechart-teal" data-percent="100" >
									<span class="percent"><b><?php echo $todayTotalBookings ?></b></span>
								</div>
								<a href="business-bookingsManagement-upcoming.php"><button class="btn bg-teal" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW DETAILS</b></button></a>
								<br><br>
								<a href="business-entranceVerification.php"><button class="btn bg-blue" ><i class="fa fa-qrcode fa-lg"></i><b>&nbsp ENTRANCE VERIFICATION</b></button></a>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br>
								<h3><b><span class="fa fa-money"></span><br>Total<br>Sales</b></h3><br>
								<h3 class="color-teal"><b>RM<?php echo $todayTotalSales ?></b></h3>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br>
								<h3><b><span class="fa fa-star"></span><br>Total<br>Loyalty Points</b></h3><br>
								<h3 class="color-teal"><b><?php echo $todayTotalLoyaltyPoints ?></b></h3>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="panel panel-default">
							<br>
							<div class="panel-body easypiechart-panel">
								<h3><b><span class="fa fa-pie-chart"></span><br>Bookings Category<br>Analysis</b></h3>
								<br>
								<div class="col-md-1"></div>
								<div class="col-md-10">
									<?php if ($todayTotalBookings): ?>
										<div id="categoryPieChartToday" style="height: 370px; width: 100%;"></div><br><br>
									<?php else: ?>
										<br><center><img src="images/icon-noResultsAvailable.png" height="280"></center><br>
										<h3 style="color: red"><b><tt>Chart Graphics Unavailable<br>(No Bookings Found)</tt></b></h3>
										<div id="categoryPieChartToday" style="height: 1px; width: 100%;"></div>
									<?php endif; ?>
								</div>
								<div class="col-md-1"></div>
							</div><!-- /.panel-body-->
							<br>
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
									<span class="percent"><b><?php echo $upcomingTotalBookings ?></b></span>
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
								<h3 class="color-orange"><b>RM<?php echo $upcomingTotalSales ?></b></h3>
								<br><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<br>
								<h3><b><span class="fa fa-star"></span><br>Total<br>Loyalty Points</b></h3><br>
								<h3 class="color-orange"><b><?php echo $upcomingTotalLoyaltyPoints ?></b></h3>
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
									<?php if ($upcomingTotalBookings): ?>
										<div id="categoryPieChartAllUpcoming" style="height: 370px; width: 100%;"></div><br><br>
									<?php else: ?>
										<br><center><img src="images/icon-noResultsAvailable.png" height="280"></center><br>
										<h3 style="color: red"><b><tt>Chart Graphics Unavailable<br>(No Bookings Found)</tt></b></h3>
										<div id="categoryPieChartAllUpcoming" style="height: 1px; width: 100%;"></div><br>
									<?php endif; ?>
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

				var categoryPieChartToday = {
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
								{ label: "Badminton", y: '<?php echo $todayTotalBadminton ?>' },
								{ label: "Basketball", y: '<?php echo $todayTotalBasketball ?>' },
								{ label: "Football", y: '<?php echo $todayTotalFootball ?>' },
								{ label: "Futsal", y: '<?php echo $todayTotalFutsal ?>' },
								{ label: "Squash", y: '<?php echo $todayTotalSquash ?>' },
								{ label: "Tennis", y: '<?php echo $todayTotalTennis ?>' }
							]
					}]
				};
				$("#categoryPieChartToday").CanvasJSChart(categoryPieChartToday);

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
								{ label: "Badminton", y: '<?php echo $upcomingTotalBadminton ?>' },
								{ label: "Basketball", y: '<?php echo $upcomingTotalBasketball ?>' },
								{ label: "Football", y: '<?php echo $upcomingTotalFootball ?>' },
								{ label: "Futsal", y: '<?php echo $upcomingTotalFutsal ?>' },
								{ label: "Squash", y: '<?php echo $upcomingTotalSquash ?>' },
								{ label: "Tennis", y: '<?php echo $upcomingTotalTennis ?>' }
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
