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

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 1 - Monday</center></div><br>
							<table id="monday_table" class="table table-stripped table-hover table-bordered">
								<?php
									//GET total number of time slots (rows) and courts (columns)
									$sqlGetBusinessFacility = mysqli_query($con,
										"SELECT * FROM businessFacility
											WHERE
												businessFacilityCategoryID='1'
												AND
												businessID='$businessID'
										");
									while ($data = $sqlGetBusinessFacility->fetch_assoc()){
										$totalNo = $data['totalNo'];
										$mondayOpeningTime = $data['mondayOpeningTime'];
										$mondayClosingTime = $data['mondayClosingTime'];
										$mondayPrice = $data['mondayPrice'];
									}
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
											<td colspan="<?php echo "$totalNo";?>"><?php echo $mondayPrice;?></td>
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

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-heading"><center>Day 2 - Tuesday</center></div><br>
							<table id="exp_cat_table" class="table table-stripped table-hover table-bordered">
								<thead>
									<tr>
										 <th id="Time" style="width:5%;"><span class="fa fa-info"></span>&nbsp Facility No</th>
										 <th id="C1" style="width:5%;">C1</th>
										 <th id="C2" style="width:5%;">C2</th>
										 <th id="C3" style="width:5%;">C3</th>
										 <th id="C4" style="width:5%;">C4</th>
										 <th id="C5" style="width:5%;">C5</th>
										 <th id="C6" style="width:5%;">C6</th>
										 <th id="C7" style="width:5%;">C7</th>
										 <th id="C8" style="width:5%;">C8</th>
										 <th id="C9" style="width:5%;">C9</th>
										 <th id="C10" style="width:5%;">C10</th>
										 <th rowspan="2" id="Action" style="width:5%;">ACTION</th>
									</tr>
									<tr>
										 <th id="Time" style="width:5%;"><span class="fa fa-clock-o"></span>&nbsp Time</th>
										 <th colspan="10" id="C1" style="width:5%;"><span class="fa fa-money"></span>&nbsp Price (RM)</th>
									</tr>
								</thead>
								<tbody class="expense">

								</tbody>
							</table>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->

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
