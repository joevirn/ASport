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
		<title>ASport for Business | Timetable Visualiser</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>

		<style>
			th, td {
			  text-align: center;
			}
		</style>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'My Facilities');
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
					<li class="active">Facility Management -> My Facilities -> Timetable Visualiser</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Timetable Visualiser</div>
					</div>
				</div>
			</div>

			<?php if ($mondayIsOpen): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 1 - Monday</center></div><br>
							<table id="monday_table" class="table table-stripped table-hover table-bordered">
								<?php
									//GET number of time slots to generate
									$totalTimeSlots = (strtotime($mondayClosingTime) - strtotime($mondayOpeningTime)) / 3600;
									$slotTime = date('H:i',strtotime($mondayOpeningTime));
								 ?>
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
								?>
										<tr>
											<th><?php echo $slotTime;?></th>
											<?php for ($j=0; $j<$totalNo; $j++) { ?>
											<td><?php echo $mondayPrice;?></td>
											<?php } ?>
										</tr>
								<?php
									$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
									$slotTime = $newTime;
									}
								?>
								</tbody>
							</table>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
			<?php endif; ?>

			<?php if ($tuesdayIsOpen): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 2 - Tuesday</center></div><br>
							<table id="monday_table" class="table table-stripped table-hover table-bordered">
								<?php
									//GET number of time slots to generate
									$totalTimeSlots = (strtotime($tuesdayClosingTime) - strtotime($tuesdayOpeningTime)) / 3600;
									$slotTime = date('H:i',strtotime($tuesdayOpeningTime));
								 ?>
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
								?>
										<tr>
											<th><?php echo $slotTime;?></th>
											<?php for ($j=0; $j<$totalNo; $j++) { ?>
											<td><?php echo $tuesdayPrice;?></td>
											<?php } ?>
										</tr>
								<?php
									$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
									$slotTime = $newTime;
									}
								?>
								</tbody>
							</table>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
			<?php endif; ?>

			<?php if ($wednesdayIsOpen): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 3 - Wednesday</center></div><br>
							<table id="monday_table" class="table table-stripped table-hover table-bordered">
								<?php
									//GET number of time slots to generate
									$totalTimeSlots = (strtotime($wednesdayClosingTime) - strtotime($wednesdayOpeningTime)) / 3600;
									$slotTime = date('H:i',strtotime($wednesdayOpeningTime));
								 ?>
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
								?>
										<tr>
											<th><?php echo $slotTime;?></th>
											<?php for ($j=0; $j<$totalNo; $j++) { ?>
											<td><?php echo $wednesdayPrice;?></td>
											<?php } ?>
										</tr>
								<?php
									$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
									$slotTime = $newTime;
									}
								?>
								</tbody>
							</table>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
			<?php endif; ?>

			<?php if ($thursdayIsOpen): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 4 - Thursday</center></div><br>
							<table id="monday_table" class="table table-stripped table-hover table-bordered">
								<?php
									//GET number of time slots to generate
									$totalTimeSlots = (strtotime($thursdayClosingTime) - strtotime($thursdayOpeningTime)) / 3600;
									$slotTime = date('H:i',strtotime($thursdayOpeningTime));
								 ?>
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
								?>
										<tr>
											<th><?php echo $slotTime;?></th>
											<?php for ($j=0; $j<$totalNo; $j++) { ?>
											<td><?php echo $thursdayPrice;?></td>
											<?php } ?>
										</tr>
								<?php
									$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
									$slotTime = $newTime;
									}
								?>
								</tbody>
							</table>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
			<?php endif; ?>

			<?php if ($fridayIsOpen): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 5 - Friday</center></div><br>
							<table id="monday_table" class="table table-stripped table-hover table-bordered">
								<?php
									//GET number of time slots to generate
									$totalTimeSlots = (strtotime($fridayClosingTime) - strtotime($fridayOpeningTime)) / 3600;
									$slotTime = date('H:i',strtotime($fridayOpeningTime));
								 ?>
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
								?>
										<tr>
											<th><?php echo $slotTime;?></th>
											<?php for ($j=0; $j<$totalNo; $j++) { ?>
											<td><?php echo $fridayPrice;?></td>
											<?php } ?>
										</tr>
								<?php
									$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
									$slotTime = $newTime;
									}
								?>
								</tbody>
							</table>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
			<?php endif; ?>

			<?php if ($saturdayIsOpen): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 6 - Saturday</center></div><br>
							<table id="monday_table" class="table table-stripped table-hover table-bordered">
								<?php
									//GET number of time slots to generate
									$totalTimeSlots = (strtotime($saturdayClosingTime) - strtotime($saturdayOpeningTime)) / 3600;
									$slotTime = date('H:i',strtotime($saturdayOpeningTime));
								 ?>
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
								?>
										<tr>
											<th><?php echo $slotTime;?></th>
											<?php for ($j=0; $j<$totalNo; $j++) { ?>
											<td><?php echo $saturdayPrice;?></td>
											<?php } ?>
										</tr>
								<?php
									$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
									$slotTime = $newTime;
									}
								?>
								</tbody>
							</table>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
			<?php endif; ?>

			<?php if ($sundayIsOpen): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 7 - Sunday</center></div><br>
							<table id="monday_table" class="table table-stripped table-hover table-bordered">
								<?php
									//GET number of time slots to generate
									$totalTimeSlots = (strtotime($sundayClosingTime) - strtotime($sundayOpeningTime)) / 3600;
									$slotTime = date('H:i',strtotime($sundayOpeningTime));
								 ?>
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
								?>
										<tr>
											<th><?php echo $slotTime;?></th>
											<?php for ($j=0; $j<$totalNo; $j++) { ?>
											<td><?php echo $sundayPrice;?></td>
											<?php } ?>
										</tr>
								<?php
									$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
									$slotTime = $newTime;
									}
								?>
								</tbody>
							</table>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
			<?php endif; ?>


			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->




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
