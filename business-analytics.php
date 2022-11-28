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
	$businessID = $_SESSION['ASportBusinessSessionCounter'];

	//for testing
	//$timezone = date_default_timezone_get();

	//GET BUSINESS NAME
	$sql = "SELECT businessName FROM business WHERE businessID=$businessID";
	$result = mysqli_query($con,$sql);
	while ($row = $result->fetch_assoc()){
		$businessName = $row['businessName'];
	}

	//THIS WEEK

	$date = new DateTime();
	$week = $date->format("W");
	$year = 2022;
	function getStartAndEndDate($week, $year) {
	  $dateTime = new DateTime();
	  $dateTime->setISODate($year, $week);
	  $result['start_date'] = $dateTime->format('Y-m-d');
	  $dateTime->modify('+6 days');
	  $result['end_date'] = $dateTime->format('Y-m-d');
	  return $result;
	}
	$dates=getStartAndEndDate($week,$year);
	//convert array to a non-associative array
	$dates = array_values($dates);

	//GET COUNT FOR TOTAL BOOKINGS AND TOTAL SALES AND BOOKINGS CATEGORY PIE CHART
	$sqlThisWeek1 = "SELECT * FROM userBookings WHERE bookingVenue='$businessName' AND bookingIsCancelled IS NULL AND bookingDate BETWEEN '$dates[0]' AND '$dates[1]'";
	$resultThisWeek1 = mysqli_query($con,$sqlThisWeek1);
	if (mysqli_num_rows($resultThisWeek1) == 0) {
		$thisWeekTotalBookings = 0;
		$thisWeekTotalSales = 0;
		$thisWeekTotalLoyaltyPoints = 0;
	}
	else {
		while ($row = $resultThisWeek1->fetch_assoc()){

			$bookingDate = $row['bookingDate'];
			$bookingPrice = $row['bookingPrice'];
			$bookingCategory = $row['bookingCategory'];

			//COUNTER FOR TOTAL SALES
			$thisWeekTotalSales += $bookingPrice;
			//COUNTER FOR TOTAL BOOKINGS
			$thisWeekTotalBookings++;
			//COUNTER FOR TOTAL BOOKINGS FOR EACH DAY
			if ( $bookingDate==$dates[0] ) {
				$mondayTotalBookings++;
			}
			elseif ( $bookingDate == date('Y-m-d', strtotime($dates[0] . ' +1 day')) ) {
				$tuesdayTotalBookings++;
			}
			elseif ( $bookingDate == date('Y-m-d', strtotime($dates[0] . ' +2 day')) ) {
				$wednesdayTotalBookings++;
			}
			elseif ( $bookingDate == date('Y-m-d', strtotime($dates[0] . ' +3 day')) ) {
				$thursdayTotalBookings++;
			}
			elseif ( $bookingDate == date('Y-m-d', strtotime($dates[0] . ' +4 day')) ) {
				$fridayTotalBookings++;
			}
			elseif ( $bookingDate == date('Y-m-d', strtotime($dates[0] . ' +5 day')) ) {
				$saturdayTotalBookings++;
			}
			elseif ( $bookingDate == date('Y-m-d', strtotime($dates[0] . ' +6 day')) ) {
				$sundayTotalBookings++;
			}
			else {
				$mondayTotalBookings=0;
				$tuesdayTotalBookings=0;
				$wednesdayTotalBookings=0;
				$thursdayTotalBookings=0;
				$fridayTotalBookings=0;
				$saturdayTotalBookings=0;
				$sundayTotalBookings=0;
			}
			//COUNTER FOR EACH BOOKING CATEGORY FOR PIE CHART
			if ($bookingCategory == "Badminton") {
				$thisWeekTotalBadminton++;
			}
			elseif ($bookingCategory == "Basketball") {
				$thisWeekTotalBasketball++;
			}
			elseif ($bookingCategory == "Football") {
				$thisWeekTotalFootball++;
			}
			elseif ($bookingCategory == "Futsal") {
				$thisWeekTotalFutsal++;
			}
			elseif ($bookingCategory == "Squash") {
				$thisWeekTotalSquash++;
			}
			elseif ($bookingCategory == "Tennis") {
				$thisWeekTotalTennis++;
			}
			else {
				$thisWeekTotalBadminton = 0;
				$thisWeekTotalBasketball = 0;
				$thisWeekTotalFootball = 0;
				$thisWeekTotalFutsal = 0;
				$thisWeekTotalSquash = 0;
				$thisWeekTotalTennis = 0;
			}
			//GET COUNT FOR TOTAL LOYALTY POINTS
			$userLoyaltyTransactionID = $row['userLoyaltyTransactionID'];
			$sqlThisWeek2 = "SELECT * FROM userLoyaltyTransactions WHERE userLoyaltyTransactionID='$userLoyaltyTransactionID'";
			$resultThisWeek2 = mysqli_query($con,$sqlThisWeek2);
			while ($row = $resultThisWeek2->fetch_assoc()){
				$pointsAddedAmount = $row['pointsAddedAmount'];
				//COUNTER FOR TOTAL LOYALTY POINTS
				$thisWeekTotalLoyaltyPoints += $pointsAddedAmount;
			}
		}
	}

	//GET COUNT FOR TOTAL CANCELLATION
	$sqlThisWeek3 = "SELECT * FROM userBookings WHERE bookingVenue='$businessName' AND bookingIsCancelled IS NOT NULL AND bookingDate BETWEEN '$dates[0]' AND '$dates[1]'";
	$resultThisWeek3 = mysqli_query($con,$sqlThisWeek3);
	if (mysqli_num_rows($resultThisWeek3) == 0) {
		$thisWeekTotalCancellation = 0;
	}
	else {
		while ($row = $resultThisWeek3->fetch_assoc()){
			//COUNTER FOR TOTAL BOOKINGS
			$thisWeekTotalCancellation++;
		}
	}



	//THIS MONTH

	//GET MONTH
	$thisMonthString = date('F Y'); //11 is November
	$thisMonth = date('Y-m'); //2022-11 is November 2022
	$firstDayOfThisMonth = date('Y-m-01');

	//GET WEEK NO
	//Week of the month = Week of the year - Week of the year of first day of month + 1
	function weekOfYear($date) {
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
        // It's the last week of the previos year.
        return 0;
    }
    else if (date('n', $date) == "12" && $weekOfYear == 1) {
        // It's the first week of the next year.
        return 53;
    }
    else {
        // It's a "normal" week.
        return $weekOfYear;
    }
	}
	function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
	}

	//GET COUNT FOR TOTAL BOOKINGS AND TOTAL SALES AND BOOKINGS CATEGORY PIE CHART
	$sqlThisMonth1 = "SELECT * FROM userBookings WHERE bookingVenue='$businessName' AND bookingIsCancelled IS NULL AND bookingDate LIKE '$thisMonth%';";
	$resultThisMonth1 = mysqli_query($con,$sqlThisMonth1);
	if (mysqli_num_rows($resultThisMonth1) == 0) {
		$thisMonthTotalBookings = 0;
		$thisMonthTotalSales = 0;
		$thisMonthTotalLoyaltyPoints = 0;
	}
	else {
		while ($row = $resultThisMonth1->fetch_assoc()){

			$bookingDate = $row['bookingDate'];
			$bookingPrice = $row['bookingPrice'];
			$bookingCategory = $row['bookingCategory'];

			//COUNTER FOR TOTAL SALES
			$thisMonthTotalSales += $bookingPrice;
			//COUNTER FOR TOTAL BOOKINGS
			$thisMonthTotalBookings++;
			//COUNTER FOR TOTAL BOOKINGS FOR EACH WEEK
			if ( weekOfMonth(strtotime($bookingDate)) == 1) {
				$week1TotalBookings++;
			}
			elseif ( weekOfMonth(strtotime($bookingDate)) == 2) {
				$week2TotalBookings++;
			}
			elseif ( weekOfMonth(strtotime($bookingDate)) == 3) {
				$week3TotalBookings++;
			}
			elseif ( weekOfMonth(strtotime($bookingDate)) == 4) {
				$week4TotalBookings++;
			}
			elseif ( weekOfMonth(strtotime($bookingDate)) == 5) {
				$week5TotalBookings++;
			}
			elseif ( weekOfMonth(strtotime($bookingDate)) == 6) {
				$week6TotalBookings++;
			}
			else {
				$week1TotalBookings=0;
				$week2TotalBookings=0;
				$week3TotalBookings=0;
				$week4TotalBookings=0;
				$week5TotalBookings=0;
				$week6TotalBookings=0;
			}
			//COUNTER FOR EACH BOOKING CATEGORY FOR PIE CHART
			if ($bookingCategory == "Badminton") {
				$thisMonthTotalBadminton++;
			}
			elseif ($bookingCategory == "Basketball") {
				$thisMonthTotalBasketball++;
			}
			elseif ($bookingCategory == "Football") {
				$thisMonthTotalFootball++;
			}
			elseif ($bookingCategory == "Futsal") {
				$thisMonthTotalFutsal++;
			}
			elseif ($bookingCategory == "Squash") {
				$thisMonthTotalSquash++;
			}
			elseif ($bookingCategory == "Tennis") {
				$thisMonthTotalTennis++;
			}
			else {
				$thisMonthTotalBadminton = 0;
				$thisMonthTotalBasketball = 0;
				$thisMonthTotalFootball = 0;
				$thisMonthTotalFutsal = 0;
				$thisMonthTotalSquash = 0;
				$thisMonthTotalTennis = 0;
			}
			//GET COUNT FOR TOTAL LOYALTY POINTS
			$userLoyaltyTransactionID = $row['userLoyaltyTransactionID'];
			$sqlThisMonth2 = "SELECT * FROM userLoyaltyTransactions WHERE userLoyaltyTransactionID='$userLoyaltyTransactionID'";
			$resultThisMonth2 = mysqli_query($con,$sqlThisMonth2);
			while ($row = $resultThisMonth2->fetch_assoc()){
				$pointsAddedAmount = $row['pointsAddedAmount'];
				//COUNTER FOR TOTAL LOYALTY POINTS
				$thisMonthTotalLoyaltyPoints += $pointsAddedAmount;
			}
		}
	}

	//GET COUNT FOR TOTAL CANCELLATION
	$sqlThisMonth3 = "SELECT * FROM userBookings WHERE bookingVenue='$businessName' AND bookingIsCancelled IS NOT NULL AND bookingDate LIKE '$thisMonth%';";
	$resultThisMonth3 = mysqli_query($con,$sqlThisMonth3);
	if (mysqli_num_rows($resultThisMonth3) == 0) {
		$thisMonthTotalCancellation = 0;
	}
	else {
		while ($row = $resultThisMonth3->fetch_assoc()){
			//COUNTER FOR TOTAL BOOKINGS
			$thisMonthTotalCancellation++;
		}
	}

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
						<div class="panel-heading"><center><?php echo $dates[0] ?> (Monday) to <?php echo $dates[1] ?> (Sunday)</center></div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-ticket"></span><br>Total Bookings</b></h3>
							<div class="easypiechart" id="easypiechart-teal" data-percent="100" >
								<span class="percent"><b><?php echo $thisWeekTotalBookings ?></b></span>
							</div>
							<h3><b><span class="fa fa-money"></span><br>Total Sales</b></h3>
							<h3 class="color-teal"><b>RM<?php echo $thisWeekTotalSales ?></b></h3>
							<h3><b><span class="fa fa-gift"></span><br>Total Loyalty Points Issued</b></h3>
							<h3 class="color-teal"><b><?php echo $thisWeekTotalLoyaltyPoints ?></b></h3>
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
							<h3><b><span class="fa fa-times"></span><br>Total Cancellation</b></h3>
							<h2 class="color-teal"><b><?php echo $thisWeekTotalCancellation ?></b></h2>
							<a href="business-bookingsManagement-cancelled.php"><button class="btn bg-teal" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW DETAILS</b></button></a>
							<br>
							<br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

				<div class="col-md-6">
					<div class="panel panel-orange">
						<div class="panel-heading"><center>THIS MONTH</center></div>
						<div class="panel-heading"><center><?php echo $thisMonthString ?></center></div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-ticket"></span><br>Total Bookings</b></h3>
							<div class="easypiechart" id="easypiechart-orange" data-percent="100" >
								<span class="percent"><b><?php echo $thisMonthTotalBookings ?></b></span>
							</div>
							<h3><b><span class="fa fa-money"></span><br>Total Sales</b></h3>
							<h3 class="color-orange"><b>RM<?php echo $thisMonthTotalSales ?></b></h3>
							<h3><b><span class="fa fa-gift"></span><br>Total Loyalty Points Issued</b></h3>
							<h3 class="color-orange"><b><?php echo $thisMonthTotalLoyaltyPoints ?></b></h3>
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
							<h3><b><span class="fa fa-times"></span><br>Total Cancellation</b></h3>
							<h2 class="color-orange"><b><?php echo $thisMonthTotalCancellation ?></b></h2>
							<a href="business-bookingsManagement-cancelled.php"><button class="btn bg-orange" ><i class="fa fa-search fa-lg"></i><b>&nbsp VIEW DETAILS</b></button></a>
							<br>
							<br>
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
							type: "doughnut",
							startAngle: 45,
							showInLegend: "true",
							legendText: "{label}",
							indexLabel: "{label} ({y})",
							yValueFormatString:"#,##0.#"%"",
							dataPoints: [
								{ label: "Badminton", y: '<?php echo $thisWeekTotalBadminton ?>' },
								{ label: "Basketball", y: '<?php echo $thisWeekTotalBasketball ?>' },
								{ label: "Football", y: '<?php echo $thisWeekTotalFootball ?>' },
								{ label: "Futsal", y: '<?php echo $thisWeekTotalFutsal ?>' },
								{ label: "Squash", y: '<?php echo $thisWeekTotalSquash ?>' },
								{ label: "Tennis", y: '<?php echo $thisWeekTotalTennis ?>' }
							]
					}]
				};
				$("#categoryPieChartThisWeek").CanvasJSChart(categoryPieChartThisWeek);

				var categoryPieChartThisMonth = {
					title: {
						text: ""
					},
					data: [{
							type: "doughnut",
							startAngle: 45,
							showInLegend: "true",
							legendText: "{label}",
							indexLabel: "{label} ({y})",
							yValueFormatString:"#,##0.#"%"",
							dataPoints: [
								{ label: "Badminton", y: '<?php echo $thisMonthTotalBadminton ?>' },
								{ label: "Basketball", y: '<?php echo $thisMonthTotalBasketball ?>' },
								{ label: "Football", y: '<?php echo $thisMonthTotalFootball ?>' },
								{ label: "Futsal", y: '<?php echo $thisMonthTotalFutsal ?>' },
								{ label: "Squash", y: '<?php echo $thisMonthTotalSquash ?>' },
								{ label: "Tennis", y: '<?php echo $thisMonthTotalTennis ?>' }
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
						type: "column",
						dataPoints: [
							{ label: "Monday", y: parseInt('<?php echo $mondayTotalBookings ?>') },
							{ label: "Tuesday", y: parseInt('<?php echo $tuesdayTotalBookings ?>') },
							{ label: "Wednesday", y: parseInt('<?php echo $wednesdayTotalBookings ?>') },
							{ label: "Thursday", y: parseInt('<?php echo $thursdayTotalBookings ?>') },
							{ label: "Friday", y: parseInt('<?php echo $fridayTotalBookings ?>') },
							{ label: "Saturday", y: parseInt('<?php echo $saturdayTotalBookings ?>') },
							{ label: "Sunday", y: parseInt('<?php echo $sundayTotalBookings ?>') }
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
						type: "column",
						dataPoints: [
							{ label: "Week 1", y: parseInt('<?php echo $week1TotalBookings ?>') },
							{ label: "Week 2", y: parseInt('<?php echo $week2TotalBookings ?>') },
							{ label: "Week 3", y: parseInt('<?php echo $week3TotalBookings ?>') },
							{ label: "Week 4", y: parseInt('<?php echo $week4TotalBookings ?>') },
							{ label: "Week 5", y: parseInt('<?php echo $week5TotalBookings ?>') },
							{ label: "Week 6", y: parseInt('<?php echo $week6TotalBookings ?>') }
						]
					}
					]
				};
				$("#barChartBookingsThisMonth").CanvasJSChart(barChartBookingsThisMonth);

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
