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

		$current_totalNo = $data['totalNo'];

		$current_mondayIsOpen = $data['mondayIsOpen'];
		$current_mondayOpeningTime = date('H:i',strtotime($data['mondayOpeningTime']));
		$current_mondayClosingTime = date('H:i',strtotime($data['mondayClosingTime']));
		$current_mondayPrice = $data['mondayPrice'];

		$current_tuesdayIsOpen = $data['tuesdayIsOpen'];
		$current_tuesdayOpeningTime = date('H:i',strtotime($data['tuesdayOpeningTime']));
		$current_tuesdayClosingTime = date('H:i',strtotime($data['tuesdayClosingTime']));
		$current_tuesdayPrice = $data['tuesdayPrice'];

		$current_wednesdayIsOpen = $data['wednesdayIsOpen'];
		$current_wednesdayOpeningTime = date('H:i',strtotime($data['wednesdayOpeningTime']));
		$current_wednesdayClosingTime = date('H:i',strtotime($data['wednesdayClosingTime']));
		$current_wednesdayPrice = $data['wednesdayPrice'];

		$current_thursdayIsOpen = $data['thursdayIsOpen'];
		$current_thursdayOpeningTime = date('H:i',strtotime($data['thursdayOpeningTime']));
		$current_thursdayClosingTime = date('H:i',strtotime($data['thursdayClosingTime']));
		$current_thursdayPrice = $data['thursdayPrice'];

		$current_fridayIsOpen = $data['fridayIsOpen'];
		$current_fridayOpeningTime = date('H:i',strtotime($data['fridayOpeningTime']));
		$current_fridayClosingTime = date('H:i',strtotime($data['fridayClosingTime']));
		$current_fridayPrice = $data['fridayPrice'];

		$current_saturdayIsOpen = $data['saturdayIsOpen'];
		$current_saturdayOpeningTime = date('H:i',strtotime($data['saturdayOpeningTime']));
		$current_saturdayClosingTime = date('H:i',strtotime($data['saturdayClosingTime']));
		$current_saturdayPrice = $data['saturdayPrice'];

		$current_sundayIsOpen = $data['sundayIsOpen'];
		$current_sundayOpeningTime = date('H:i',strtotime($data['sundayOpeningTime']));
		$current_sundayClosingTime = date('H:i',strtotime($data['sundayClosingTime']));
		$current_sundayPrice = $data['sundayPrice'];

		$timeStampAdded = $data['timeStampAdded'];
		$timeStampEdited = $data['timeStampEdited'];
	}

	$sql = "SELECT * FROM businessFacilityCategories WHERE businessFacilityCategoryID='$businessFacilityCategoryID'";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$categoryName = $data['categoryName'];
	}

	if(isset($_POST['submit']))
	{
	  $totalNo = $_POST['totalNo'];

		$mondayIsOpen = $_POST['mondayIsOpen'];
		$mondayOpeningTime = $_POST['mondayOpeningTime'];
		$mondayClosingTime = $_POST['mondayClosingTime'];
		$mondayPrice = $_POST['mondayPrice'];

		$tuesdayIsOpen = $_POST['tuesdayIsOpen'];
		$tuesdayOpeningTime = $_POST['tuesdayOpeningTime'];
		$tuesdayClosingTime = $_POST['tuesdayClosingTime'];
		$tuesdayPrice = $_POST['tuesdayPrice'];

		$wednesdayIsOpen = $_POST['wednesdayIsOpen'];
		$wednesdayOpeningTime = $_POST['wednesdayOpeningTime'];
		$wednesdayClosingTime = $_POST['wednesdayClosingTime'];
		$wednesdayPrice = $_POST['wednesdayPrice'];

		$thursdayIsOpen = $_POST['thursdayIsOpen'];
		$thursdayOpeningTime = $_POST['thursdayOpeningTime'];
		$thursdayClosingTime = $_POST['thursdayClosingTime'];
		$thursdayPrice = $_POST['thursdayPrice'];

		$fridayIsOpen = $_POST['fridayIsOpen'];
		$fridayOpeningTime = $_POST['fridayOpeningTime'];
		$fridayClosingTime = $_POST['fridayClosingTime'];
		$fridayPrice = $_POST['fridayPrice'];

		$saturdayIsOpen = $_POST['saturdayIsOpen'];
		$saturdayOpeningTime = $_POST['saturdayOpeningTime'];
		$saturdayClosingTime = $_POST['saturdayClosingTime'];
		$saturdayPrice = $_POST['saturdayPrice'];

		$sundayIsOpen = $_POST['sundayIsOpen'];
		$sundayOpeningTime = $_POST['sundayOpeningTime'];
		$sundayClosingTime = $_POST['sundayClosingTime'];
		$sundayPrice = $_POST['sundayPrice'];

		//ADD FORM FIELDS TO DATABASE
	  $sqlUpdate = mysqli_query($con,
	    "UPDATE
				businessFacility
			SET
				totalNo = '$totalNo',
				mondayIsOpen = '$mondayIsOpen',
				mondayOpeningTime = '$mondayOpeningTime',
				mondayClosingTime = '$mondayClosingTime',
				tuesdayPrice = '$tuesdayPrice',
				tuesdayIsOpen = '$tuesdayIsOpen',
				tuesdayOpeningTime = '$tuesdayOpeningTime',
				tuesdayClosingTime = '$tuesdayClosingTime',
				tuesdayPrice = '$tuesdayPrice',
				wednesdayIsOpen = '$wednesdayIsOpen',
				wednesdayOpeningTime = '$wednesdayOpeningTime',
				wednesdayClosingTime = '$wednesdayClosingTime',
				wednesdayPrice = '$wednesdayPrice',
				thursdayIsOpen = '$thursdayIsOpen',
				thursdayOpeningTime = '$thursdayOpeningTime',
				thursdayClosingTime = '$thursdayClosingTime',
				thursdayPrice = '$thursdayPrice',
				fridayIsOpen = '$fridayIsOpen',
				fridayOpeningTime = '$fridayOpeningTime',
				fridayClosingTime = '$fridayClosingTime',
				fridayPrice = '$fridayPrice',
				saturdayIsOpen = '$saturdayIsOpen',
				saturdayOpeningTime = '$saturdayOpeningTime',
				saturdayClosingTime = '$saturdayClosingTime',
				saturdayPrice = '$saturdayPrice',
				sundayIsOpen = '$sundayIsOpen',
				sundayOpeningTime = '$sundayOpeningTime',
				sundayClosingTime = '$sundayClosingTime',
				sundayPrice = '$sundayPrice',
				timeStampEdited = now()
			WHERE
				businessFacilityID = '$businessFacilityID'
				AND
				businessID = '$businessID'
			");

		//JAVASCRIPT ALERT STATUS

		//Facility Add Status
	  if($sqlUpdate){
	    echo "<script>alert('Facility has been updated!');</script>";
			echo "<script>window.location.href='business-facilityManagement-myFacilities2.php?businessFacilityID=$businessFacilityID'</script>";
	  }
		else {
			echo "<script>alert('There is a problem updating this facility. Please try again.');</script>";
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
		<title>ASport for Business | Edit Facility Information</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>

		<style>
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
					<li class="active">Facility Management -> My Facilities -> <?php echo $categoryName ?> -> Edit Facility Information</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Edit Facility Information</div>
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
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Badminton</b></h4>
										<p><img src="images/badminton.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==2) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Basketball</b></h4>
										<p><img src="images/basketball.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==3) { ?>
						<div class="col-md-3">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Football</b></h4>
										<p><img src="images/football.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==4) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Futsal</b></h4>
										<p><img src="images/futsal.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==5) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Squash</b></h4>
										<p><img src="images/squash.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==6) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Tennis</b></h4>
										<p><img src="images/tennis.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
				<?php
				}
				?>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>EDIT<br>Facility Information</b></h3><br><br>
							<form role="form" method="post" action="">
	              <div class="col-md-2"></div>
	  						<div class="col-md-8">
	                <div class="form-group">
	                  <label><span class="fa fa-info-circle"></span>&nbsp Total Number of Facilities of This Category</label>
	                  <input class="form-control" type="number" name="totalNo" min="1" max="20" step="1" required="true" value="<?php echo $current_totalNo ?>">
	                </div>
									<br>
									<div class="panel-heading"><center><span class="fa fa-calendar"></span>&nbsp Opening Hours & Price</center></div><br>
	              </div>
								<div class="col-md-2"></div>
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="mondayIsOpen" value="0">
											<input type="checkbox" name="mondayIsOpen" id="mondayIsOpen" value="1" onclick="EnableDisableMonday(this)">
										<label for="Monday"><h4><b>&nbsp Monday</b></h4></label>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Opening Time</label>
										<input class="form-control" type="time" step="1800" name="mondayOpeningTime" id='mondayOpeningTime' value="<?php echo $current_mondayOpeningTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="mondayClosingTime" id='mondayClosingTime' value="<?php echo $current_mondayClosingTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="mondayPrice" id='mondayPrice' min="1" value="<?php echo $current_mondayPrice ?>" readonly="readonly">
									</div>
									<br>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="tuesdayIsOpen" value="0">
										<input type="checkbox" name="tuesdayIsOpen" id="tuesdayIsOpen" value="1" onclick="EnableDisableTuesday(this)">
										<label for="Monday"><h4><b>&nbsp Tuesday</b></h4></label>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Opening Time</label>
										<input class="form-control" type="time" step="1800" name="tuesdayOpeningTime" id='tuesdayOpeningTime' value="<?php echo $current_tuesdayOpeningTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="tuesdayClosingTime" id='tuesdayClosingTime' value="<?php echo $current_tuesdayClosingTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="tuesdayPrice" id='tuesdayPrice' min="1" value="<?php echo $current_tuesdayPrice ?>" readonly="readonly">
									</div>
									<br>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="wednesdayIsOpen" value="0">
										<input type="checkbox" name="wednesdayIsOpen" id="wednesdayIsOpen" value="1" onclick="EnableDisableWednesday(this)">
										<label for="Monday"><h4><b>&nbsp Wednesday</b></h4></label>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Opening Time</label>
										<input class="form-control" type="time" step="1800" name="wednesdayOpeningTime" id='wednesdayOpeningTime' value="<?php echo $current_wednesdayOpeningTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="wednesdayClosingTime" id='wednesdayClosingTime' value="<?php echo $current_wednesdayClosingTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="wednesdayPrice" id='wednesdayPrice' min="1" value="<?php echo $current_wednesdayPrice ?>" readonly="readonly">
									</div>
									<br>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="thursdayIsOpen" value="0">
										<input type="checkbox" name="thursdayIsOpen" id="thursdayIsOpen" value="1" onclick="EnableDisableThursday(this)">
										<label for="Monday"><h4><b>&nbsp Thursday</b></h4></label>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Opening Time</label>
										<input class="form-control" type="time" step="1800" name="thursdayOpeningTime" id='thursdayOpeningTime' value="<?php echo $current_thursdayOpeningTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="thursdayClosingTime" id='thursdayClosingTime' value="<?php echo $current_thursdayClosingTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="thursdayPrice" id='thursdayPrice' min="1" value="<?php echo $current_thursdayPrice ?>" readonly="readonly">
									</div>
									<br>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="fridayIsOpen" value="0">
										<input type="checkbox" name="fridayIsOpen" id="fridayIsOpen" value="1" onclick="EnableDisableFriday(this)">
										<label for="Monday"><h4><b>&nbsp Friday</b></h4></label>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Opening Time</label>
										<input class="form-control" type="time" step="1800" name="fridayOpeningTime" id='fridayOpeningTime' value="<?php echo $current_fridayOpeningTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="fridayClosingTime" id='fridayClosingTime' value="<?php echo $current_fridayClosingTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="fridayPrice" id='fridayPrice' min="1" value="<?php echo $current_fridayPrice ?>" readonly="readonly">
									</div>
									<br>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="saturdayIsOpen" value="0">
										<input type="checkbox" name="saturdayIsOpen" id="saturdayIsOpen" value="1" onclick="EnableDisableSaturday(this)">
										<label for="Monday"><h4><b>&nbsp Saturday</b></h4></label>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Opening Time</label>
										<input class="form-control" type="time" step="1800" name="saturdayOpeningTime" id='saturdayOpeningTime' value="<?php echo $current_saturdayOpeningTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="saturdayClosingTime" id='saturdayClosingTime' value="<?php echo $current_saturdayClosingTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="saturdayPrice" id='saturdayPrice' min="1" value="<?php echo $current_saturdayPrice ?>" readonly="readonly">
									</div>
									<br>
								</div>
								<div class="col-md-4"></div>
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="sundayIsOpen" value="0">
										<input type="checkbox" name="sundayIsOpen" id="sundayIsOpen" value="1" onclick="EnableDisableSunday(this)">
										<label for="Monday"><h4><b>&nbsp Sunday</b></h4></label>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Opening Time</label>
										<input class="form-control" type="time" step="1800" name="sundayOpeningTime" id='sundayOpeningTime' value="<?php echo $current_sundayOpeningTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="sundayClosingTime" id='sundayClosingTime' value="<?php echo $current_sundayClosingTime ?>" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="sundayPrice" id='sundayPrice' min="1" value="<?php echo $current_sundayPrice ?>" readonly="readonly">
									</div>
									<br>
								</div>
								<br>
								<div class="col-md-12">
								<div align="center" class="form-group has-success">
									<br>
									<button type="submit" class="btn btn-primary" name="submit" style="width: 40%;">UPDATE</button>
								</div>
							</form>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->

			</div><!-- /.row-->

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

		<script type="text/javascript">

			window.onload=function(){
				if (<?php echo $current_mondayIsOpen ?>) {
					document.getElementById("mondayIsOpen").click();
				}
				if (<?php echo $current_tuesdayIsOpen ?>) {
					document.getElementById("tuesdayIsOpen").click();
				}
				if (<?php echo $current_wednesdayIsOpen ?>) {
					document.getElementById("wednesdayIsOpen").click();
				}
				if (<?php echo $current_thursdayIsOpen ?>) {
					document.getElementById("thursdayIsOpen").click();
				}
				if (<?php echo $current_fridayIsOpen ?>) {
					document.getElementById("fridayIsOpen").click();
				}
				if (<?php echo $current_saturdayIsOpen ?>) {
					document.getElementById("saturdayIsOpen").click();
				}
				if (<?php echo $current_sundayIsOpen ?>) {
					document.getElementById("sundayIsOpen").click();
				}
			};

			function httpGet(theUrl){
		    var xmlHttp = new XMLHttpRequest();
		    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
		    xmlHttp.send( null );
		    return xmlHttp.responseText;
			}
			function EnableDisableMonday(mondayIsOpen) {
					var mondayOpeningTime = document.getElementById("mondayOpeningTime");
					var mondayClosingTime = document.getElementById("mondayClosingTime");
					var mondayPrice = document.getElementById("mondayPrice");
					mondayOpeningTime.readOnly = mondayIsOpen.checked ? false : true;
					mondayClosingTime.readOnly = mondayIsOpen.checked ? false : true;
					mondayPrice.readOnly = mondayIsOpen.checked ? false : true;
			}
			function EnableDisableTuesday(tuesdayIsOpen) {
					var tuesdayOpeningTime = document.getElementById("tuesdayOpeningTime");
					var tuesdayClosingTime = document.getElementById("tuesdayClosingTime");
					var tuesdayPrice = document.getElementById("tuesdayPrice");
					tuesdayOpeningTime.readOnly = tuesdayIsOpen.checked ? false : true;
					tuesdayClosingTime.readOnly = tuesdayIsOpen.checked ? false : true;
					tuesdayPrice.readOnly = tuesdayIsOpen.checked ? false : true;
			}
			function EnableDisableWednesday(wednesdayIsOpen) {
					var wednesdayOpeningTime = document.getElementById("wednesdayOpeningTime");
					var wednesdayClosingTime = document.getElementById("wednesdayClosingTime");
					var wednesdayPrice = document.getElementById("wednesdayPrice");
					wednesdayOpeningTime.readOnly = wednesdayIsOpen.checked ? false : true;
					wednesdayClosingTime.readOnly = wednesdayIsOpen.checked ? false : true;
					wednesdayPrice.readOnly = wednesdayIsOpen.checked ? false : true;
			}
			function EnableDisableThursday(thursdayIsOpen) {
					var thursdayOpeningTime = document.getElementById("thursdayOpeningTime");
					var thursdayClosingTime = document.getElementById("thursdayClosingTime");
					var thursdayPrice = document.getElementById("thursdayPrice");
					thursdayOpeningTime.readOnly = thursdayIsOpen.checked ? false : true;
					thursdayClosingTime.readOnly = thursdayIsOpen.checked ? false : true;
					thursdayPrice.readOnly = thursdayIsOpen.checked ? false : true;
			}
			function EnableDisableFriday(fridayIsOpen) {
					var fridayOpeningTime = document.getElementById("fridayOpeningTime");
					var fridayClosingTime = document.getElementById("fridayClosingTime");
					var fridayPrice = document.getElementById("fridayPrice");
					fridayOpeningTime.readOnly = fridayIsOpen.checked ? false : true;
					fridayClosingTime.readOnly = fridayIsOpen.checked ? false : true;
					fridayPrice.readOnly = fridayIsOpen.checked ? false : true;
			}
			function EnableDisableSaturday(saturdayIsOpen) {
					var saturdayOpeningTime = document.getElementById("saturdayOpeningTime");
					var saturdayClosingTime = document.getElementById("saturdayClosingTime");
					var saturdayPrice = document.getElementById("saturdayPrice");
					saturdayOpeningTime.readOnly = saturdayIsOpen.checked ? false : true;
					saturdayClosingTime.readOnly = saturdayIsOpen.checked ? false : true;
					saturdayPrice.readOnly = saturdayIsOpen.checked ? false : true;
			}
			function EnableDisableSunday(sundayIsOpen) {
					var sundayOpeningTime = document.getElementById("sundayOpeningTime");
					var sundayClosingTime = document.getElementById("sundayClosingTime");
					var sundayPrice = document.getElementById("sundayPrice");
					sundayOpeningTime.readOnly = sundayIsOpen.checked ? false : true;
					sundayClosingTime.readOnly = sundayIsOpen.checked ? false : true;
					sundayPrice.readOnly = sundayIsOpen.checked ? false : true;
			}
		</script>

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
