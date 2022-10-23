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

	if(isset($_POST['submit']))
	{
		$businessID = $_SESSION['ASportBusinessSessionCounter'];

		$facilityCategoryName = $_POST['facilityCategoryName'];
		$sqlFacilityCategoryID = mysqli_query($con,
			"SELECT businessFacilityCategoryID, categoryName
				FROM businessFacilityCategories
				WHERE categoryName='Badminton'
			");
		while ($row = $sqlFacilityCategoryID->fetch_assoc()){
			$facilityCategoryID = $row['businessFacilityCategoryID'];
		}

	  $totalNo = $_POST['totalNo'];
		$openingMonday = $_POST['openingMonday'];
		$openingTuesday = $_POST['openingTuesday'];
		$openingWednesday = $_POST['openingWednesday'];
		$openingThursday = $_POST['openingThursday'];
		$openingFriday = $_POST['openingFriday'];
		$openingSaturday = $_POST['openingSaturday'];
		$openingSunday = $_POST['openingSunday'];
		$defaultOpeningTime = $_POST['defaultOpeningTime'];
		$defaultClosingTime = $_POST['defaultClosingTime'];
		$defaultPrice = $_POST['defaultPrice'];

		//ADD FORM FIELDS TO DATABASE
	  $sqlAdd = mysqli_query($con,
	    "INSERT INTO businessFacility(businessID, businessFacilityCategoryID, totalNo, openingMonday, openingTuesday, openingWednesday, openingThursday, openingFriday, openingSaturday, openingSunday, defaultOpeningTime, defaultClosingTime, defaultPrice)
	     VALUE            					('$businessID','$facilityCategoryID','$totalNo','$openingMonday','$openingTuesday','$openingWednesday','$openingThursday','$openingFriday','$openingSaturday','$openingSunday','$defaultOpeningTime','$defaultClosingTime','$defaultPrice')
			");

		//GENERATE DEFAULT SCHEDULER

		//GET businessFacilityID
		$sqlBusinessFacilityID = mysqli_query($con,
			"SELECT businessFacilityID
				FROM businessFacility
				WHERE businessFacilityCategoryID=$facilityCategoryID
			");
		while ($row = $sqlBusinessFacilityID->fetch_assoc()){
			$businessFacilityID = $row['businessFacilityID'];
		}

		//GET number of time slots to generate
		$totalTimeSlots = (strtotime($defaultClosingTime) - strtotime($defaultOpeningTime)) / 3600;
		$slotTime = $defaultOpeningTime;

		//MONDAY
		if ($openingMonday=='1') {
			//generate hourly timeslots based on opening and closing time
			for ($i=0; $i<$totalTimeSlots; $i++) {
				$facilityNo = '1';
				//add court number columns based on number of courts
				for ($j=0; $j<$totalNo; $j++) {
					$sqlGenerateDefaultScheduler = mysqli_query($con,
						"INSERT INTO businessFacilitySchedule(businessID, businessFacilityID, day, startTime, facilityNo, facilityPrice)
						 VALUE            										('$businessID','$businessFacilityID','Monday','$slotTime','$facilityNo','$defaultPrice')
						");
					$facilityNo++;
				}
				$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
				$slotTime = $newTime;
			}
		}
		//TUESDAY
		if ($openingTuesday=='1') {
			//generate hourly timeslots based on opening and closing time
			for ($i=0; $i<$totalTimeSlots; $i++) {
				$facilityNo = '1';
				//add court number columns based on number of courts
				for ($j=0; $j<$totalNo; $j++) {
					$sqlGenerateDefaultScheduler = mysqli_query($con,
						"INSERT INTO businessFacilitySchedule(businessID, businessFacilityID, day, startTime, facilityNo, facilityPrice)
						 VALUE            										('$businessID','$businessFacilityID','Tuesday','$slotTime','$facilityNo','$defaultPrice')
						");
					$facilityNo++;
				}
				$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
				$slotTime = $newTime;
			}
		}
		//WEDNESDAY
		if ($openingWednesday=='1') {
			//generate hourly timeslots based on opening and closing time
			for ($i=0; $i<$totalTimeSlots; $i++) {
				$facilityNo = '1';
				//add court number columns based on number of courts
				for ($j=0; $j<$totalNo; $j++) {
					$sqlGenerateDefaultScheduler = mysqli_query($con,
						"INSERT INTO businessFacilitySchedule(businessID, businessFacilityID, day, startTime, facilityNo, facilityPrice)
						 VALUE            										('$businessID','$businessFacilityID','Wednesday','$slotTime','$facilityNo','$defaultPrice')
						");
					$facilityNo++;
				}
				$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
				$slotTime = $newTime;
			}
		}
		//THURSDAY
		if ($openingThursday=='1') {
			//generate hourly timeslots based on opening and closing time
			for ($i=0; $i<$totalTimeSlots; $i++) {
				$facilityNo = '1';
				//add court number columns based on number of courts
				for ($j=0; $j<$totalNo; $j++) {
					$sqlGenerateDefaultScheduler = mysqli_query($con,
						"INSERT INTO businessFacilitySchedule(businessID, businessFacilityID, day, startTime, facilityNo, facilityPrice)
						 VALUE            										('$businessID','$businessFacilityID','Thursday','$slotTime','$facilityNo','$defaultPrice')
						");
					$facilityNo++;
				}
				$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
				$slotTime = $newTime;
			}
		}
		//FRIDAY
		if ($openingFriday=='1') {
			//generate hourly timeslots based on opening and closing time
			for ($i=0; $i<$totalTimeSlots; $i++) {
				$facilityNo = '1';
				//add court number columns based on number of courts
				for ($j=0; $j<$totalNo; $j++) {
					$sqlGenerateDefaultScheduler = mysqli_query($con,
						"INSERT INTO businessFacilitySchedule(businessID, businessFacilityID, day, startTime, facilityNo, facilityPrice)
						 VALUE            										('$businessID','$businessFacilityID','Friday','$slotTime','$facilityNo','$defaultPrice')
						");
					$facilityNo++;
				}
				$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
				$slotTime = $newTime;
			}
		}
		//SATURDAY
		if ($openingSaturday=='1') {
			//generate hourly timeslots based on opening and closing time
			for ($i=0; $i<$totalTimeSlots; $i++) {
				$facilityNo = '1';
				//add court number columns based on number of courts
				for ($j=0; $j<$totalNo; $j++) {
					$sqlGenerateDefaultScheduler = mysqli_query($con,
						"INSERT INTO businessFacilitySchedule(businessID, businessFacilityID, day, startTime, facilityNo, facilityPrice)
						 VALUE            										('$businessID','$businessFacilityID','Saturday','$slotTime','$facilityNo','$defaultPrice')
						");
					$facilityNo++;
				}
				$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
				$slotTime = $newTime;
			}
		}
		//SUNDAY
		if ($openingSunday=='1') {
			//generate hourly timeslots based on opening and closing time
			for ($i=0; $i<$totalTimeSlots; $i++) {
				$facilityNo = '1';
				//add court number columns based on number of courts
				for ($j=0; $j<$totalNo; $j++) {
					$sqlGenerateDefaultScheduler = mysqli_query($con,
						"INSERT INTO businessFacilitySchedule(businessID, businessFacilityID, day, startTime, facilityNo, facilityPrice)
						 VALUE            										('$businessID','$businessFacilityID','Sunday','$slotTime','$facilityNo','$defaultPrice')
						");
					$facilityNo++;
				}
				$newTime = date('H:i',strtotime('+1 hour',strtotime($slotTime)));
				$slotTime = $newTime;
			}
		}

		//JAVASCRIPT ALERT STATUS

		//Facility Add Status
	  if($sqlAdd){
	    echo "<script>alert('Facility has been added!');</script>";
	  }
		else {
			echo "<script>alert('There is a problem adding this facility. Please try again.');</script>";
		}

		//Default Scheduler Generation Status
		if($sqlGenerateDefaultScheduler){
			echo "<script>alert('Default scheduler has been generated!');</script>";
			echo "<script>window.location.href='business-facilityManagement-myFacilities.php'</script>";
		}
	  else {
	    echo "<script>alert('There is a problem generating a default schedule. Please try again.');</script>";
	  }
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
		<title>ASport for Business | Add New Facility</title>
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
      .panel-body input[type=checkbox]:checked + label {
        text-decoration: underline;
        color: #777;
      }
		</style>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Add New Facility');
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
					<li class="active">Facility Management -> Add New Facility</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Add New Facility</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>Add A New Facility</b></h3>
							<form role="form" method="post" action="">
	              <div class="col-md-2"></div>
	  						<div class="col-md-8">
									<div class="form-group">
										<label><span class="fa fa-list"></span>&nbsp Category</label>
										<select class="form-control" name="facilityCategoryName">
											<option value="" selected="true" disabled="disabled">SELECT CATEGORY</option>
											<?php
												$sql = $con->query("SELECT categoryName FROM businessFacilityCategories ORDER BY categoryName");
												while($data = $sql->fetch_array()) {
													echo "<option>".$data['categoryName']."</option>";
												}
											?>
										</select>
									</div>
	                <div class="form-group">
	                  <label><span class="fa fa-info-circle"></span>&nbsp Total Number of Facilities of This Category</label>
	                  <input class="form-control" type="number" name="totalNo" min="1" max="20" step="1" required="true">
	                </div>
                  <div class="form-group">
                    <label><span class="fa fa-calendar"></span>&nbsp Facility Opening Days</label><br>
										<input type="hidden" name="openingMonday" value="0">
                    <input type="checkbox" name="openingMonday" value="1">
                    <label for="Monday">&nbsp Monday</label><br>
										<input type="hidden" name="openingTuesday" value="0">
                    <input type="checkbox" name="openingTuesday" value="1">
                    <label for="Tuesday">&nbsp Tuesday</label><br>
										<input type="hidden" name="openingWednesday" value="0">
                    <input type="checkbox" name="openingWednesday" value="1">
                    <label for="Wednesday">&nbsp Wednesday</label><br>
										<input type="hidden" name="openingThursday" value="0">
                    <input type="checkbox" name="openingThursday" value="1">
                    <label for="Thursday">&nbsp Thursday</label><br>
										<input type="hidden" name="openingFriday" value="0">
                    <input type="checkbox" name="openingFriday" value="1">
                    <label for="Friday">&nbsp Friday</label><br>
										<input type="hidden" name="openingSaturday" value="0">
                    <input type="checkbox" name="openingSaturday" value="1">
                    <label for="Saturday">&nbsp Saturday</label><br>
										<input type="hidden" name="openingSunday" value="0">
                    <input type="checkbox" name="openingSunday" value="1">
                    <label for="Sunday">&nbsp Sunday</label><br>
                  </div>
                  <div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Default Opening Time</label>
                    <input class="form-control" type="time" step="1800" name="defaultOpeningTime" required="true">
									</div>
                  <div class="form-group">
                    <label><span class="fa fa-clock-o"></span>&nbsp Default Closing Time</label>
                    <input class="form-control" type="time" step="1800" name="defaultClosingTime" required="true">
                  </div>
                  <div class="form-group">
                    <label><span class="fa fa-money"></span>&nbsp Default Price Per Hour (RM)</label>
                    <input class="form-control" type="number" name="defaultPrice" min="1" required="true">
                  </div>
									<br>
									<div align="center" class="form-group has-success">
										<button type="submit" class="btn btn-primary" name="submit" style="width: 50%;">ADD</button>
									</div>
	              </div>
								<div class="col-md-2"></div>
							</form>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
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
