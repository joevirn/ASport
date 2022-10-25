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
	  $sqlAdd = mysqli_query($con,
	    "INSERT INTO businessFacility(businessID, businessFacilityCategoryID, totalNo,
																		mondayIsOpen, mondayOpeningTime, mondayClosingTime, mondayPrice,
																		tuesdayIsOpen, tuesdayOpeningTime, tuesdayClosingTime, tuesdayPrice,
																		wednesdayIsOpen, wednesdayOpeningTime, wednesdayClosingTime, wednesdayPrice,
																		thursdayIsOpen, thursdayOpeningTime, thursdayClosingTime, thursdayPrice,
																		fridayIsOpen, fridayOpeningTime, fridayClosingTime, fridayPrice,
																		saturdayIsOpen, saturdayOpeningTime, saturdayClosingTime, saturdayPrice,
																		sundayIsOpen, sundayOpeningTime, sundayClosingTime, sundayPrice)
	     VALUE            					('$businessID', '$facilityCategoryID', '$totalNo',
																	 '$mondayIsOpen', '$mondayOpeningTime', '$mondayClosingTime', '$mondayPrice',
																	 '$tuesdayIsOpen', '$tuesdayOpeningTime', '$tuesdayClosingTime', '$tuesdayPrice',
																	 '$wednesdayIsOpen', '$wednesdayOpeningTime', '$wednesdayClosingTime', '$wednesdayPrice',
																	 '$thursdayIsOpen', '$thursdayOpeningTime', '$thursdayClosingTime', '$thursdayPrice',
																	 '$fridayIsOpen', '$fridayOpeningTime', '$fridayClosingTime', '$fridayPrice',
																	 '$saturdayIsOpen', '$saturdayOpeningTime', '$saturdayClosingTime', '$saturdayPrice',
																	 '$sundayIsOpen', '$sundayOpeningTime', '$sundayClosingTime', '$sundayPrice')
			");

		//JAVASCRIPT ALERT STATUS

		//Facility Add Status
	  if($sqlAdd){
	    echo "<script>alert('Facility has been added!');</script>";
			echo "<script>window.location.href='business-facilityManagement-myFacilities1.php'</script>";
	  }
		else {
			echo "<script>alert('There is a problem adding this facility. Please try again.');</script>";
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
										<select class="form-control" name="facilityCategoryName" required>
											<option value="" selected="true">SELECT CATEGORY</option>
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
									<br>
									<h3 align="center"><b><span class="fa fa-calendar"></span>&nbsp Add Opening Hours</b></h3><br>
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
										<input class="form-control" type="time" step="1800" name="mondayOpeningTime" id='mondayOpeningTime' value="10:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="mondayClosingTime" id='mondayClosingTime' value="22:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="mondayPrice" id='mondayPrice' min="1" value="10" readonly="readonly">
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
										<input class="form-control" type="time" step="1800" name="tuesdayOpeningTime" id='tuesdayOpeningTime' value="10:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="tuesdayClosingTime" id='tuesdayClosingTime' value="22:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="tuesdayPrice" id='tuesdayPrice' min="1" value="10" readonly="readonly">
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
										<input class="form-control" type="time" step="1800" name="wednesdayOpeningTime" id='wednesdayOpeningTime' value="10:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="wednesdayClosingTime" id='wednesdayClosingTime' value="22:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="wednesdayPrice" id='wednesdayPrice' min="1" value="10" readonly="readonly">
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
										<input class="form-control" type="time" step="1800" name="thursdayOpeningTime" id='thursdayOpeningTime' value="10:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="thursdayClosingTime" id='thursdayClosingTime' value="22:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="thursdayPrice" id='thursdayPrice' min="1" value="10" readonly="readonly">
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
										<input class="form-control" type="time" step="1800" name="fridayOpeningTime" id='fridayOpeningTime' value="10:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="fridayClosingTime" id='fridayClosingTime' value="22:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="fridayPrice" id='fridayPrice' min="1" value="10" readonly="readonly">
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
										<input class="form-control" type="time" step="1800" name="saturdayOpeningTime" id='saturdayOpeningTime' value="10:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="saturdayClosingTime" id='saturdayClosingTime' value="22:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="saturdayPrice" id='saturdayPrice' min="1" value="10" readonly="readonly">
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
										<input class="form-control" type="time" step="1800" name="sundayOpeningTime" id='sundayOpeningTime' value="10:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Closing Time</label>
										<input class="form-control" type="time" step="1800" name="sundayClosingTime" id='sundayClosingTime' value="22:00" readonly="readonly">
									</div>
									<div class="form-group">
										<label><span class="fa fa-money"></span>&nbsp Price Per Hour (RM)</label>
										<input class="form-control" type="number" name="sundayPrice" id='sundayPrice' min="1" value="10" readonly="readonly">
									</div>
									<br>
								</div>
								<br>
								<div class="col-md-12">
								<div align="center" class="form-group has-success">
									<br>
									<button type="submit" class="btn btn-primary" name="submit" style="width: 40%;">ADD</button>
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
