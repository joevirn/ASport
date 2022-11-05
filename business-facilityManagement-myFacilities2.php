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
		<title>ASport for Business | My Facilities</title>
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
					<li class="active">Facility Management -> My Facilities -> <?php echo $categoryName;?></li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">My Facilities</div>
					</div>
				</div>
			</div>

			<div class="row">
				<?php
				$sql = "SELECT * FROM businessFacility WHERE businessID='$businessID' AND businessFacilityID='$businessFacilityID'";
				$result = mysqli_query($con,$sql);

				while ($column = $result->fetch_array()){
					$businessFacilityID = $column['businessFacilityID'];
					$businessFacilityCategoryID = $column['businessFacilityCategoryID'];
				?>
					<?php if ($businessFacilityCategoryID==1) { ?>
						<div class="col-md-6">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
						<div class="col-md-6">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
						<div class="col-md-6">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
						<div class="col-md-6">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
						<div class="col-md-6">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
						<div class="col-md-6">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
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
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h4><b><span class="fa fa-pencil"></span>&nbsp Last Update: </b><?php echo $timeStampEdited ?></h4>
							<h4><b><span class="fa fa-file-o"></span>&nbsp First Created: </b><?php echo $timeStampAdded ?></h4>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Total No of Courts</b></h3>
							<div class="easypiechart" id="easypiechart-blue" data-percent="100" >
	              <span class="percent">
	                <?php echo "$totalNo" ?>
	              </span>
	            </div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Opening Hours & Price</b></h3><br><br>
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
								</table><br><br>
							</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Facility Layout</b></h3><br>
							<?php if ($layoutFileName): ?>
								<p><img src="<?php echo $layoutFileName;?>" width="80%" height="80%" style="border: 1px solid"></p><br>
							<?php else: ?>
								<center><img src="images/icon-noImageAvailable.png" width="50%" height="50%"></center><br><br>
							<?php endif; ?>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div>

			<div class="row">
				<div class="col-md-3">
					<a href="business-facilityManagement-myFacilities-timetableVisualiser.php?businessFacilityID=<?php echo $businessFacilityID ?>">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>VIEW</b><br>Timetable Visualiser</h3>
								<br><p><img src="images/calendar.png" width="180" height="180"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-3">
					<a href="business-facilityManagement-myFacilities-editInformation.php?businessFacilityID=<?php echo $businessFacilityID ?>">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>EDIT</b><br>Facility Information</h3>
								<br><p><img src="images/edit.png" width="180" height="180"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-3">
					<a href="business-facilityManagement-myFacilities-editLayout.php?businessFacilityID=<?php echo $businessFacilityID ?>">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>EDIT</b><br>Facility Layout</h3>
								<br><p><img src="images/edit.png" width="180" height="180"></p><br>
							</div><!-- /.panel-body-->
						</div><!-- /.panel-->
					</a>
				</div><!-- /.col-->
				<div class="col-md-3">
					<a href="business-facilityManagement-myFacilities-delete.php?businessFacilityID=<?php echo "$businessFacilityID";?>" onclick="return confirm('Are you sure to delete this facility? This action cannot be reverted!')">
						<div class="panel panel-default">
							<div class="panel-body easypiechart-panel">
								<h3><b>DELETE</b><br>This Facility</h3>
								<br><p><img src="images/delete.png" width="180" height="180"></p><br>
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
