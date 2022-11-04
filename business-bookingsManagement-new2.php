<?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the business id in the session is being cleared, log out the business
if (strlen($_SESSION['ASportBusinessSessionCounter'] == 0)) {
	header('location:business-logout.php');
}
else {
	$businessID = $_SESSION['ASportBusinessSessionCounter'];
	$businessFacilityID = $_GET['businessFacilityID'];
	$bookingDateForAvailabilityCheck = $_POST['bookingDateForAvailabilityCheck'];

	$sql = "SELECT * FROM businessFacility WHERE businessFacilityID='$businessFacilityID' AND businessID='$businessID'";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$businessFacilityID = $data['businessFacilityID'];
		$businessFacilityCategoryID = $data['businessFacilityCategoryID'];

		$totalNo = $data['totalNo'];

		$mondayIsOpen = $data['mondayIsOpen'];
		$mondayOpeningTime = date('H:i',strtotime($data['mondayOpeningTime']));
		$mondayClosingTime = date('H:i',strtotime($data['mondayClosingTime']));
		$mondayPrice = $data['mondayPrice'];

		$tuesdayIsOpen = $data['tuesdayIsOpen'];
		$tuesdayOpeningTime = date('H:i',strtotime($data['tuesdayOpeningTime']));
		$tuesdayClosingTime = date('H:i',strtotime($data['tuesdayClosingTime']));
		$tuesdayPrice = $data['tuesdayPrice'];

		$wednesdayIsOpen = $data['wednesdayIsOpen'];
		$wednesdayOpeningTime = date('H:i',strtotime($data['wednesdayOpeningTime']));
		$wednesdayClosingTime = date('H:i',strtotime($data['wednesdayClosingTime']));
		$wednesdayPrice = $data['wednesdayPrice'];

		$thursdayIsOpen = $data['thursdayIsOpen'];
		$thursdayOpeningTime = date('H:i',strtotime($data['thursdayOpeningTime']));
		$thursdayClosingTime = date('H:i',strtotime($data['thursdayClosingTime']));
		$thursdayPrice = $data['thursdayPrice'];

		$fridayIsOpen = $data['fridayIsOpen'];
		$fridayOpeningTime = date('H:i',strtotime($data['fridayOpeningTime']));
		$fridayClosingTime = date('H:i',strtotime($data['fridayClosingTime']));
		$fridayPrice = $data['fridayPrice'];

		$saturdayIsOpen = $data['saturdayIsOpen'];
		$saturdayOpeningTime = date('H:i',strtotime($data['saturdayOpeningTime']));
		$saturdayClosingTime = date('H:i',strtotime($data['saturdayClosingTime']));
		$saturdayPrice = $data['saturdayPrice'];

		$sundayIsOpen = $data['sundayIsOpen'];
		$sundayOpeningTime = date('H:i',strtotime($data['sundayOpeningTime']));
		$sundayClosingTime = date('H:i',strtotime($data['sundayClosingTime']));
		$sundayPrice = $data['sundayPrice'];

		$timeStampAdded = $data['timeStampAdded'];
		$timeStampEdited = $data['timeStampEdited'];

		$layoutFileName = $data['layoutFileName'];
	}

	$sql = "SELECT * FROM businessFacilityCategories WHERE businessFacilityCategoryID='$businessFacilityCategoryID'";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$categoryName = $data['categoryName'];
	}

?>

	<!DOCTYPE html>
	<!--start of html-->
	<html>

	<!--start of head-->

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport for Business | Add A New Booking</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>

		<style>
			table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%;
			}
			td, th {
				border: 1px solid #dddddd;
				text-align: center;
				padding: 8px;
			}
			.available {
				background-color: white;
			}
			td:hover.available{
			 cursor: pointer;
			 background-color: #30a5ff;
			}
			.booked {
				background-color: lightgray;
			}
			.locked {
				background-color: gray;
			}
			.selection {
				background-color: #30a5ff;
			}
		</style>
	</head>
	<!--end of head-->

	<!--start of body-->
	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'New');
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
					<li><a href="business-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Bookings Management -> Add A New Booking -> <?php echo $categoryName;?></li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Add A New Booking</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>Make A New Booking</b></h3>
								<div class="col-md-1"></div>
								<div class="col-md-10">

									<script src="js/jquery-1.11.1.min.js"></script>
									<form action="" method="post" id="formForAvailabilityCheck">
										<h5><b>Step 1: Select Preferred Booking Date</b></h5>
										<div class="form-group">
											<label><span class="fa fa-calendar"></span>&nbsp Date</label>
											<input class="form-control" type="date" name="bookingDateForAvailabilityCheck" id="bookingDateForAvailabilityCheck" min="" max="" onkeydown="return false" required="true" value="<?php echo $bookingDateForAvailabilityCheck ?>">
										</div>
									</form>

									<h5><b>Step 2: Check Available Slots</b></h5>
									<label><span class="fa fa-table"></span>&nbsp <a href="#liveAvailability">View Live Availability</a></label>

									<h5><b>Step 3: Select Available Slots</b></h5>
									<div class="form-group">
										<label><span class="fa fa-info-circle"></span>&nbsp Facility No</label>
										<select class="form-control" name="bookingFacilityNo">
											<option value="" selected="true" disabled="disabled">SELECT AVAILABLE COURT</option>
											<?php
											if (isset($_POST['bookingDateForAvailabilityCheck'])) {
												for ($i=1; $i <= $totalNo; $i++) {
													echo "<option>$i</option>";
												}
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Start Time</label>
										<select class="form-control" name="bookingStartTime">
											<option value="" selected="true" disabled="disabled">SELECT AVAILABLE START TIME</option>
											<?php
											if (isset($_POST['bookingDateForAvailabilityCheck'])) {
												$bookingDateForAvailabilityCheck = $_POST['bookingDateForAvailabilityCheck'];
												$selectedDayNo = date('w', strtotime($bookingDateForAvailabilityCheck)); //0 is Sunday and 6 is Saturday

												if ($selectedDayNo==0 && $sundayIsOpen==1) {
													//GET number of time slots to generate
													$totalTimeSlots = (strtotime($sundayClosingTime) - strtotime($sundayOpeningTime)) / 3600;
													$slotTime = date('H:i',strtotime($sundayOpeningTime));
													$slotPrice = $sundayPrice;
													for ($i=0; $i < $totalTimeSlots; $i++) {
														echo "<option>$slotTime</option>";
														$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
														$slotTime = $newTime;
													}
												}
												else if ($selectedDayNo==1 && $mondayIsOpen==1) {
													//GET number of time slots to generate
													$totalTimeSlots = (strtotime($mondayClosingTime) - strtotime($mondayOpeningTime)) / 3600;
													$slotTime = date('H:i',strtotime($mondayOpeningTime));
													$slotPrice = $mondayPrice;
													for ($i=0; $i < $totalTimeSlots; $i++) {
														echo "<option>$slotTime</option>";
														$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
														$slotTime = $newTime;
													}
												}
												else if ($selectedDayNo==2 && $tuesdayIsOpen==1) {
													//GET number of time slots to generate
													$totalTimeSlots = (strtotime($tuesdayClosingTime) - strtotime($tuesdayOpeningTime)) / 3600;
													$slotTime = date('H:i',strtotime($tuesdayOpeningTime));
													$slotPrice = $tuesdayPrice;
													for ($i=0; $i < $totalTimeSlots; $i++) {
														echo "<option>$slotTime</option>";
														$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
														$slotTime = $newTime;
													}
												}
												elseif ($selectedDayNo==3 && $wednesdayIsOpen==1) {
													//GET number of time slots to generate
													$totalTimeSlots = (strtotime($wednesdayClosingTime) - strtotime($wednesdayOpeningTime)) / 3600;
													$slotTime = date('H:i',strtotime($wednesdayOpeningTime));
													$slotPrice = $wednesdayPrice;
													for ($i=0; $i < $totalTimeSlots; $i++) {
														echo "<option>$slotTime</option>";
														$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
														$slotTime = $newTime;
													}
												}
												elseif ($selectedDayNo==4 && $thursdayIsOpen==1) {
													//GET number of time slots to generate
													$totalTimeSlots = (strtotime($thursdayClosingTime) - strtotime($thursdayOpeningTime)) / 3600;
													$slotTime = date('H:i',strtotime($thursdayOpeningTime));
													$slotPrice = $thursdayPrice;
													for ($i=0; $i < $totalTimeSlots; $i++) {
														echo "<option>$slotTime</option>";
														$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
														$slotTime = $newTime;
													}
												}
												elseif ($selectedDayNo==5 && $fridayIsOpen==1) {
													//GET number of time slots to generate
													$totalTimeSlots = (strtotime($fridayClosingTime) - strtotime($fridayOpeningTime)) / 3600;
													$slotTime = date('H:i',strtotime($fridayOpeningTime));
													$slotPrice = $fridayPrice;
													for ($i=0; $i < $totalTimeSlots; $i++) {
														echo "<option>$slotTime</option>";
														$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
														$slotTime = $newTime;
													}
												}
												elseif ($selectedDayNo==6 && $saturdayIsOpen==1) {
													//GET number of time slots to generate
													$totalTimeSlots = (strtotime($saturdayClosingTime) - strtotime($saturdayOpeningTime)) / 3600;
													$slotTime = date('H:i',strtotime($saturdayOpeningTime));
													$slotPrice = $saturdayPrice;
													for ($i=0; $i < $totalTimeSlots; $i++) {
														echo "<option>$slotTime</option>";
														$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
														$slotTime = $newTime;
													}
												}
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label><span class="fa fa-list"></span>&nbsp Duration (hour)</label>
										<select class="form-control" name="bookingDuration">
											<option value="" selected="true" disabled="disabled">SELECT AVAILABLE DURATION</option>
											<?php
											if (isset($_POST['bookingDateForAvailabilityCheck'])) {
												echo "<option>1</option>";
												echo "<option>2</option>";
											}
											?>
										</select>
									</div>
									<br>
									<div align="center" class="form-group has-success">
										<button type="submit" class="btn btn-primary" name="next" style="width: 50%;">NEXT</button>
									</div>
								</div>
								<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->

					<a id="liveAvailability"></a>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center><span class="fa fa-table"></span>&nbsp Live Availability Status</center></div>
							<?php if (isset($_POST['bookingDateForAvailabilityCheck'])):?>
									<h3><b><center><?php echo $bookingDateForAvailabilityCheck ?></center></b></h3><br>
									<table id="legend">
										<tr>
											 <th id="Legend" style="width:10%;">Legend:</th>
											 <td id="Available" style="width:10%; text-align:right;">Available</td>
											 <td id="AvailableColor" style="width:10%;" class="available"></td>
											 <td id="Booked" style="width:10%; text-align:right;">Booked</td>
											 <td id="BookedColor" style="width:10%;" class="booked">B</td>
											 <td id="Locked" style="width:10%; text-align:right;">Locked</td>
											 <td id="LockedColor" style="width:10%;" class="locked">L</td>
										</tr>
									</table><br>

									<table id="sunday_table" class="table table-stripped table-hover table-bordered">
										<thead>
											<tr>
												 <th id="Facility No" style="width:5%;"><span class="fa fa-info"></span>&nbsp Facility No</th>
												 <?php
												 $facilityNoHeader = '1';
												 for ($i=0; $i < $totalNo; $i++) {
												 ?>
													<th style="width:5%"><?php echo "C$facilityNoHeader";?></th>
												 <?php
												 $facilityNoHeader++;
												 }
												 ?>
											</tr>
											<tr>
												 <th id="Time" style="width:5%;"><span class="fa fa-clock-o"></span>&nbsp Time</th>
												 <th colspan="<?php echo "$totalNo"; ?>" id="C1" style="width:5%;"><span class="fa fa-money"></span>&nbsp Price (RM)</th>
											</tr>
										</thead>
										<tbody>
										<?php
											//generate rows (start time)
											for ($i=0; $i<$totalTimeSlots; $i++) {
												$facilityNo = 1;
										?>
												<tr>
													<th><?php echo $slotTime;?></th>
													<?php for ($j=0; $j<$totalNo; $j++) {?>
													<td><?php echo $slotPrice;?></td>
													<?php
													$facilityNo++;
													}
													?>
												</tr>
										<?php
											$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
											$slotTime = $newTime;
											}
										?>
										</tbody>
									</table>

							<?php else: ?>
								<br>
								<center><img src="images/unavailable.png" width="400" height="400"></center>
								<h3><center><font color=red>PLEASE SELECT A DATE!</font></center></h3>

							<?php endif; ?>


						</div><!-- /.panel-body-->
					</div><!-- /.panel-->

				</div><!-- /.col-->

				<?php
				$sql = "SELECT * FROM businessFacility WHERE businessID='$businessID' AND businessFacilityID='$businessFacilityID'";
				$result = mysqli_query($con,$sql);

				while ($column = $result->fetch_array()){
					$businessFacilityID = $column['businessFacilityID'];
					$businessFacilityCategoryID = $column['businessFacilityCategoryID'];
				?>
					<?php if ($businessFacilityCategoryID==1) { ?>
						<div class="col-md-5">
							<a href="business-bookingsManagement-new1.php">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Badminton</b></h4>
										<p><img src="images/badminton.png" width="200" height="200"></p><br>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==2) { ?>
						<div class="col-md-5">
						<a href="business-bookingsManagement-new1.php">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Basketball</b></h4>
										<p><img src="images/basketball.png" width="200" height="200"></p><br>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==3) { ?>
						<div class="col-md-5">
							<a href="business-bookingsManagement-new1.php">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Football</b></h4>
										<p><img src="images/football.png" width="200" height="200"></p><br>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==4) { ?>
						<div class="col-md-5">
							<a href="business-bookingsManagement-new1.php">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Futsal</b></h4>
										<p><img src="images/futsal.png" width="200" height="200"></p><br>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==5) { ?>
						<div class="col-md-5">
							<a href="business-bookingsManagement-new1.php">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Squash</b></h4>
										<p><img src="images/squash.png" width="200" height="200"></p><br>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==6) { ?>
						<div class="col-md-5">
							<a href="business-bookingsManagement-new1.php">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Tennis</b></h4>
										<p><img src="images/tennis.png" width="200" height="200"></p><br>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
				<?php
				}
				?>

				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Facility Layout</b></h3><br>
							<?php if ($layoutFileName): ?>
								<p><img src="<?php echo $layoutFileName;?>" width="80%" height="80%" style="border: 1px solid"></p><br>
							<?php else: ?>
								<center><img src="images/business/icon-noImageAvailable.png" width="50%" height="50%"></center><br><br>
							<?php endif; ?>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Opening Hours & Price</b></h3><br>
							<div class="col-md-12">
								<table id="exp_cat_table" class="table table-stripped table-hover table-bordered">
									<thead>
										<tr>
											<th id="" style="width:5%;"></th>
											<th id="OpeningTime" style="width:5%;"><span class="fa fa-clock-o"></span>&nbsp Opening Time</th>
											<th id="ClosingTime" style="width:5%;"><span class="fa fa-clock-o"></span>&nbsp Closing Time</th>
											<th id="Price" style="width:5%;"><span class="fa fa-money"></span>&nbsp Price</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th id="Monday" style="width:5%;"><span class="fa fa-calendar-o"></span>&nbsp Monday</th>
										<?php if ($mondayIsOpen): ?>
											<td id="mondayOpeningTime" style="width:5%;"><?php echo "$mondayOpeningTime";?></td>
											<td id="mondayClosingTime" style="width:5%;"><?php echo "$mondayClosingTime";?></td>
											<td id="mondayPrice" style="width:5%;"><?php echo "RM$mondayPrice";?></td>
										<?php else: ?>
											<td colspan="3" id="CLOSED" style="width:5%;">CLOSED</td>
										<?php endif; ?>
										</tr>
										<tr>
											<th id="Tuesday" style="width:5%;"><span class="fa fa-calendar-o"></span>&nbsp Tuesday</th>
										<?php if ($tuesdayIsOpen): ?>
											<td id="tuesdayOpeningTime" style="width:5%;"><?php echo "$tuesdayOpeningTime";?></td>
											<td id="tuesdayClosingTime" style="width:5%;"><?php echo "$tuesdayClosingTime";?></td>
											<td id="tuesdayPrice" style="width:5%;"><?php echo "RM$tuesdayPrice";?></td>
										<?php else: ?>
											<td colspan="3" id="CLOSED" style="width:5%;">CLOSED</td>
										<?php endif; ?>
										</tr>
										<tr>
											<th id="Wednesday" style="width:5%;"><span class="fa fa-calendar-o"></span>&nbsp Wednesday</th>
										<?php if ($wednesdayIsOpen): ?>
											<td id="wednesdayOpeningTime" style="width:5%;"><?php echo "$wednesdayOpeningTime";?></td>
											<td id="wednesdayClosingTime" style="width:5%;"><?php echo "$wednesdayClosingTime";?></td>
											<td id="wednesdayPrice" style="width:5%;"><?php echo "RM$wednesdayPrice";?></td>
										<?php else: ?>
											<td colspan="3" id="CLOSED" style="width:5%;">CLOSED</td>
										<?php endif; ?>
										</tr>
										<tr>
											<th id="Thursday" style="width:5%;"><span class="fa fa-calendar-o"></span>&nbsp Thursday</th>
										<?php if ($thursdayIsOpen): ?>
											<td id="thursdayOpeningTime" style="width:5%;"><?php echo "$thursdayOpeningTime";?></td>
											<td id="thursdayClosingTime" style="width:5%;"><?php echo "$thursdayClosingTime";?></td>
											<td id="thursdayPrice" style="width:5%;"><?php echo "RM$thursdayPrice";?></td>
										<?php else: ?>
											<td colspan="3" id="CLOSED" style="width:5%;">CLOSED</td>
										<?php endif; ?>
										</tr>
										<tr>
											<th id="Friday" style="width:5%;"><span class="fa fa-calendar-o"></span>&nbsp Friday</th>
										<?php if ($fridayIsOpen): ?>
											<td id="fridayOpeningTime" style="width:5%;"><?php echo "$fridayOpeningTime";?></td>
											<td id="fridayClosingTime" style="width:5%;"><?php echo "$fridayClosingTime";?></td>
											<td id="fridayPrice" style="width:5%;"><?php echo "RM$fridayPrice";?></td>
										<?php else: ?>
											<td colspan="3" id="CLOSED" style="width:5%;">CLOSED</td>
										<?php endif; ?>
										</tr>
										<tr>
											<th id="Saturday" style="width:5%;"><span class="fa fa-calendar-o"></span>&nbsp Saturday</th>
										<?php if ($saturdayIsOpen): ?>
											<td id="saturdayOpeningTime" style="width:5%;"><?php echo "$saturdayOpeningTime";?></td>
											<td id="saturdayClosingTime" style="width:5%;"><?php echo "$saturdayClosingTime";?></td>
											<td id="saturdayPrice" style="width:5%;"><?php echo "RM$saturdayPrice";?></td>
										<?php else: ?>
											<td colspan="3" id="CLOSED" style="width:5%;">CLOSED</td>
										<?php endif; ?>
										</tr>
										<tr>
											<th id="Sunday" style="width:5%;"><span class="fa fa-calendar-o"></span>&nbsp Sunday</th>
										<?php if ($sundayIsOpen): ?>
											<td id="sundayOpeningTime" style="width:5%;"><?php echo "$sundayOpeningTime";?></td>
											<td id="sundayClosingTime" style="width:5%;"><?php echo "$sundayClosingTime";?></td>
											<td id="sundayPrice" style="width:5%;"><?php echo "RM$sundayPrice";?></td>
										<?php else: ?>
											<td colspan="3" id="CLOSED" style="width:5%;">CLOSED</td>
										<?php endif; ?>
										</tr>
									</tbody>
								</table><br>
							</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

			</div><!-- /.row-->

			<script>
				//get booking date for today for min date input eligibility
				var dateToday = new Date();
				var ddToday = dateToday.getDate();
				var mmToday = dateToday.getMonth() + 1; //January is 0!
				var yyyyToday = dateToday.getFullYear();
				if (ddToday < 10) {
				   ddToday = '0' + ddToday;
				}
				if (mmToday < 10) {
				   mmToday = '0' + mmToday;
				}
				today = yyyyToday + '-' + mmToday + '-' + ddToday;
				document.getElementById("bookingDateForAvailabilityCheck").setAttribute("min", today);

				//get booking date for 2 weeks from today for max date input eligibility
				var dateNext2Weeks = new Date(Date.now() + 12096e5); //12096e5 is 14 days in milliseconds
				var ddNext2Weeks = dateNext2Weeks.getDate();
				var mmNext2Weeks = dateNext2Weeks.getMonth() + 1; //January is 0!
				var yyyyNext2Weeks = dateNext2Weeks.getFullYear();
				if (ddNext2Weeks < 10) {
					 ddNext2Weeks = '0' + ddNext2Weeks;
				}
				if (mmNext2Weeks < 10) {
					 mmNext2Weeks = '0' + mmNext2Weeks;
				}
				next2Weeks = yyyyNext2Weeks + '-' + mmNext2Weeks + '-' + ddNext2Weeks;
				document.getElementById("bookingDateForAvailabilityCheck").setAttribute("max", next2Weeks);

				$('#bookingDateForAvailabilityCheck').change(function(){
					console.log('Submiting form');
					$('#formForAvailabilityCheck').submit();
				});
			</script>

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

	</body>
	<!--end of body-->

	</html>
	<!--end of html-->

<?php
}
?>
