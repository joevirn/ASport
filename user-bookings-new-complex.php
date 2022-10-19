<!-- <?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the user id in the session is being cleared, log out the user
if (strlen($_SESSION['detsuid'] == 0)) {
	header('location:user-logout.php');
} else {
?> -->

	<!DOCTYPE html>
	<!--start of html-->
	<html>

	<!--start of head-->

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport | New Booking - Relau Sports Complex</title>
		<?php
	  include('includes/user-head-styles.php');
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
		define('PAGE', 'New Booking');
		include_once('includes/user-header.php');
		include_once('includes/user-sidebar.php');
		?>

		<!--start of division class 1-->
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<!--start of division class 2-->
			<div class="row">
				<!--start of ordered list-->
				<ol class="breadcrumb">
					<!--start of list-->
					<li><a href="user-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">New Booking -> Badminton -> Relau Sports Complex</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Relau Sports Complex</div>
					</div>
				</div>
			</div>

			<div class="row">

				<form role="form" method="post" action="user-bookings-new-confirmation.php">
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-body">
	            <h3 align="center"><b>Make A New Booking</b></h3>
	              <div class="col-md-1"></div>
	  						<div class="col-md-10">
									<h5><b>Step 1: Select Category & Date</b></h5>
									<div class="form-group">
										<label><span class="fa fa-list"></span>&nbsp Category</label>
										<select class="form-control" name="bookingCategory">
											<option value="" selected="true" disabled="disabled">SELECT CATEGORY</option>
											<?php
												// $sql = $con->query("SELECT name FROM income_categories WHERE userID='".$_SESSION['detsuid']."' ORDER BY position");
												// while($data = $sql->fetch_array()) {
												// 	echo "<option>".$data['name']."</option>";
												// }
											?>
										</select>
									</div>
	                <div class="form-group">
	                  <label><span class="fa fa-calendar"></span>&nbsp Date</label>
	                  <input class="form-control" type="date" name="bookingDate" required="true">
	                </div>

									<h5><b>Step 2: Check Available Slots</b></h5>
									<label><span class="fa fa-table"></span>&nbsp <a href="#liveAvailability">View Live Availability</a></label>

									<h5><b>Step 3: Select Available Slots</b></h5>
									<div class="form-group">
										<label><span class="fa fa-info-circle"></span>&nbsp Facility No</label>
										<select class="form-control" name="bookingFacilityNo">
											<option value="" selected="true" disabled="disabled">SELECT AVAILABLE COURT</option>
											<?php
												// $sql = $con->query("SELECT name FROM income_categories WHERE userID='".$_SESSION['detsuid']."' ORDER BY position");
												// while($data = $sql->fetch_array()) {
												// 	echo "<option>".$data['name']."</option>";
												// }
											?>
										</select>
									</div>
									<div class="form-group">
										<label><span class="fa fa-clock-o"></span>&nbsp Start Time</label>
										<select class="form-control" name="bookingStartTime">
											<option value="" selected="true" disabled="disabled">SELECT AVAILABLE START TIME</option>
											<?php
												// $sql = $con->query("SELECT name FROM income_categories WHERE userID='".$_SESSION['detsuid']."' ORDER BY position");
												// while($data = $sql->fetch_array()) {
												// 	echo "<option>".$data['name']."</option>";
												// }
											?>
										</select>
									</div>
									<div class="form-group">
										<label><span class="fa fa-list"></span>&nbsp Duration</label>
										<select class="form-control" name="bookingDuration">
											<option value="" selected="true" disabled="disabled">SELECT AVAILABLE DURATION</option>
											<?php
												// $sql = $con->query("SELECT name FROM income_categories WHERE userID='".$_SESSION['detsuid']."' ORDER BY position");
												// while($data = $sql->fetch_array()) {
												// 	echo "<option>".$data['name']."</option>";
												// }
											?>
										</select>
									</div>
									<br>
									<div align="center" class="form-group has-success">
										<button type="submit" class="btn btn-primary" name="submit" style="width: 50%;">NEXT</button>
									</div>
	              </div>
								<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->

					<a id="liveAvailability"></a>
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>Live Availability</b></h3>
							<br>
								<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="form-group">
										<label><span class="fa fa-table"></span>&nbsp Available Check</label>
										<table id="legend">
											<tr>
												 <th id="Legend" style="width:10%;">Legend:</th>
												 <td id="Available" style="width:10%; text-align:right;">Available</td>
												 <td id="AvailableColor" style="width:10%;" class="available">RM</td>
												 <td id="Booked" style="width:10%; text-align:right;">Booked</td>
												 <td id="BookedColor" style="width:10%;" class="booked">B</td>
												 <td id="Locked" style="width:10%; text-align:right;">Locked</td>
												 <td id="LockedColor" style="width:10%;" class="locked">L</td>
												 <td id="Selection" style="width:10%; text-align:right;">Selection</td>
												 <td id="SelectionColour" style="width:10%;" class="selection"></td>
											</tr>
										</table>
										<br>
										<table id="bookingTable" name="bookingTable" verifybooking="false">
										 <thead>
												<tr>
													 <th id="Time" style="width:10%;">Time</th>
													 <th id="C1" style="width:10%;">C1</th>
													 <th id="C2" style="width:10%;">C2</th>
													 <th id="C3" style="width:10%;">C3</th>
													 <th id="C4" style="width:10%;">C4</th>
													 <th id="C5" style="width:10%;">C5</th>
													 <th id="C6" style="width:10%;">C6</th>
													 <th id="C7" style="width:10%;">C7</th>
													 <th id="C8" style="width:10%;">C8</th>
													 <th id="C9" style="width:10%;">C9</th>
													 <th id="C10" style="width:10%;">C10</th>
												</tr>
												<tr>
													 <th id="T1" price="15" startTime="0900" endTime="1000" timeSlotname="0900">09:00</td>
													 <td id="20221001-T1-C1" price="28" status="0" courtname="Court 1" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T1-C2" price="28" status="0" courtname="Court 2" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T1-C3" price="28" status="1" courtname="Court 3" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T1-C4" price="28" status="0" courtname="Court 4" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T1-C5" price="28" status="1" courtname="Court 5" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T1-C6" price="28" status="0" courtname="Court 6" group="1" style="width:10%;" class="locked">L</td>
													 <td id="20221001-T1-C7" price="28" status="0" courtname="Court 7" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T1-C8" price="28" status="0" courtname="Court 8" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T1-C9" price="28" status="0" courtname="Court 9" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T1-C10" price="28" status="0" courtname="Court 10" group="1" style="width:10%;" class="available">RM28</td>
												</tr>
												<tr>
													 <th id="T2" price="15" startTime="1000" endTime="1100" timeSlotname="1000">10:00</td>
													 <td id="20221001-T2-C1" price="28" status="0" courtname="Court 1" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C2" price="28" status="0" courtname="Court 2" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C3" price="28" status="1" courtname="Court 3" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T2-C4" price="28" status="0" courtname="Court 4" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C5" price="28" status="1" courtname="Court 5" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T2-C6" price="28" status="0" courtname="Court 6" group="1" style="width:10%;" class="locked">L</td>
													 <td id="20221001-T2-C7" price="28" status="0" courtname="Court 7" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C8" price="28" status="0" courtname="Court 8" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C9" price="28" status="0" courtname="Court 9" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C10" price="28" status="0" courtname="Court 10" group="1" style="width:10%;" class="available">RM28</td>
												</tr>
												<tr>
													 <th id="T3" price="15" startTime="1100" endTime="1200" timeSlotname="1100">11:00</td>
													 <td id="20221001-T2-C1" price="28" status="0" courtname="Court 1" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C2" price="28" status="0" courtname="Court 2" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C3" price="28" status="1" courtname="Court 3" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T2-C4" price="28" status="0" courtname="Court 4" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C5" price="28" status="1" courtname="Court 5" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T2-C6" price="28" status="0" courtname="Court 6" group="1" style="width:10%;" class="locked">L</td>
													 <td id="20221001-T2-C7" price="28" status="0" courtname="Court 7" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C8" price="28" status="0" courtname="Court 8" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C9" price="28" status="0" courtname="Court 9" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C10" price="28" status="0" courtname="Court 10" group="1" style="width:10%;" class="available">RM28</td>
												</tr>
												<tr>
													 <th id="T2" price="15" startTime="1000" endTime="1100" timeSlotname="1000">12:00</td>
													 <td id="20221001-T2-C1" price="28" status="0" courtname="Court 1" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C2" price="28" status="0" courtname="Court 2" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C3" price="28" status="1" courtname="Court 3" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T2-C4" price="28" status="0" courtname="Court 4" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C5" price="28" status="1" courtname="Court 5" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T2-C6" price="28" status="0" courtname="Court 6" group="1" style="width:10%;" class="locked">L</td>
													 <td id="20221001-T2-C7" price="28" status="0" courtname="Court 7" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C8" price="28" status="0" courtname="Court 8" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C9" price="28" status="0" courtname="Court 9" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C10" price="28" status="0" courtname="Court 10" group="1" style="width:10%;" class="available">RM28</td>
												</tr>
												<tr>
													 <th id="T2" price="15" startTime="1000" endTime="1100" timeSlotname="1000">13:00</td>
													 <td id="20221001-T2-C1" price="28" status="0" courtname="Court 1" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C2" price="28" status="0" courtname="Court 2" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C3" price="28" status="1" courtname="Court 3" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T2-C4" price="28" status="0" courtname="Court 4" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C5" price="28" status="1" courtname="Court 5" group="1" style="width:10%;" class="booked">B</td>
													 <td id="20221001-T2-C6" price="28" status="0" courtname="Court 6" group="1" style="width:10%;" class="locked">L</td>
													 <td id="20221001-T2-C7" price="28" status="0" courtname="Court 7" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C8" price="28" status="0" courtname="Court 8" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C9" price="28" status="0" courtname="Court 9" group="1" style="width:10%;" class="available">RM28</td>
													 <td id="20221001-T2-C10" price="28" status="0" courtname="Court 10" group="1" style="width:10%;" class="available">RM28</td>
												</tr>
										 </thead>
										</table>
									</div>
									<?php
										if($msg){
											echo "<p style='color:red;'>";
											echo $msg;
											echo "</p>";
										}
									?>
									<br>
								</div>
								<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->

				</div><!-- /.col-->
				</form>

				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Facility Layout</b></h3>
								<table>
									<tr>
										<td style="border:none;" width="100%"><img src="images/badminton-court-layout.png" width="200" height="200"></td>
									</tr>
								</table>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>Venue Information</b></h3>
							<p><img src="images/facilities-relausportscomplex.png" width="100%" height="250"></p>
							<h4><b>Relau Sports Complex</b></h4>
							<h5><b>Bayan Lepas, Penang</b></h5>
							<p>
								<a href="" class="btn btn-default" style="width: 35%;">View Venue Details</a>
							</p>
						</div>
					</div>
				</div>
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

		<script>
			$("td.available").click(function(){
				if (confirm('Confirm your slot selection.')) {
				  window.location = "user-bookings-new-confirmation.php";
				}
			});
		</script>

	</body>
	<!--end of body-->

	</html>
	<!--end of html-->

<?php
}
?>
