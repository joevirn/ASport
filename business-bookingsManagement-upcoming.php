<?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the user id in the session is being cleared, log out the user
if (strlen($_SESSION['ASportBusinessSessionCounter'] == 0)) {
	header('location:user-logout.php');
}
else {

	$businessID = $_SESSION['ASportBusinessSessionCounter'];

	$sql = "SELECT businessName FROM business WHERE businessID=$businessID";
	$result = mysqli_query($con,$sql);
	while ($row = $result->fetch_assoc()){
		$businessName = $row['businessName'];
	}

	$sql = "SELECT * FROM userBookings WHERE bookingVenue='$businessName' AND bookingDate>=CURDATE()";
	$result = mysqli_query($con,$sql);
	while ($row = $result->fetch_assoc()){
		$count++;
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
		<title>ASport for Business | Upcoming Bookings</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>
		<!-- for data tables -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Upcoming');
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
					<li class="active">Bookings Management -> Upcoming</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Upcoming Bookings</div>
					</div>
				</div>
			</div>

			<div class="row">
	      <div class="col-md-12">
	        <div class="panel panel-default">
	          <div class="panel-body easypiechart-panel">
	            <h3><b><span class="fa fa-arrow-up"></span><br>Upcoming Bookings</b></h3>
	            <div class="easypiechart" id="easypiechart-blue" data-percent="100" >
	              <span class="percent">
	                <?php echo "$count" ?>
	              </span>
	            </div>
	            <br>
	            <div class="col-md-12">
	              <table class="table table-bordered table-striped">
	                <thead>
	                  <tr>
	                    <th style="text-align: center"><span class="fa fa-calendar"></span><br>Date</th>
											<th style="text-align: center"><span class="fa fa-clock-o"></span><br>Start Time</th>
											<th style="text-align: center"><span class="fa fa-clock-o"></span><br>End Time</th>
											<th style="text-align: center"><span class="fa fa-list"></span><br>Duration (Hours)</th>
	                    <th style="text-align: center"><span class="fa fa-th-large"></span><br>Category</th>
											<th style="text-align: center"><span class="fa fa-info-circle"></span><br>Facility No</th>
											<th style="text-align: center"><span class="fa fa-money"></span><br>Price (RM)</th>
											<th style="text-align: center"><span class="fa fa-id-card-o"></span><br>Booking ID</th>
											<th style="text-align: center"><span class="fa fa-info"></span><br>Customer Name</th>
											<th style="text-align: center"><span class="fa fa-phone"></span><br>Customer Phone Number</th>
											<th style="text-align: center"><span class="fa fa-envelope"></span><br>Customer Email</th>
											<th style="text-align: center"><span class="fa fa-eye"></span><br>ACTION</th>
	                  </tr>
	                </thead>
	                <tbody>
	                  <?php
										$sql = "SELECT * FROM userBookings WHERE bookingVenue='$businessName' AND bookingDate>=CURDATE()";
										$result = mysqli_query($con,$sql);
										while ($row = $result->fetch_assoc()){

											$id=$row['userID'];
											$sql2 = "SELECT * FROM users WHERE userID=$id";
											$result2 = mysqli_query($con,$sql2);
											while ($row2 = $result2->fetch_assoc()){
												$userName = $row2['userName'];
												$userPhoneNumber = $row2['userPhoneNumber'];
												$userEmail = $row2['userEmail'];
											}
	                  ?>
	                    <tr>
	                      <td><b><?php echo $row['bookingDate'];?></b></td>
	                      <td><?php echo $row['bookingStartTime'];?></td>
	                      <td><?php echo $row['bookingEndTime'];?></td>
	                      <td><?php echo $row['bookingDuration'];?></td>
												<td><?php echo $row['bookingCategory'];?></td>
												<td><?php echo $row['bookingFacilityNo'];?></td>
												<td><?php echo $row['bookingPrice'];?></td>
						            <td><?php echo $row['userBookingID'];?></td>
												<td><?php echo $userName;?></td>
												<td><?php echo $userPhoneNumber;?></td>
												<td><?php echo $userEmail;?></td>
												<td><a target="_blank" href="business-entranceVerification.php?userBookingID=<?php echo $row['userBookingID'];?>&userID=<?php echo $row['userID'];?>"><b>VERIFY</b></a></td>
	                    </tr>
	                  <?php
	                  }
	                  ?>
	                </tbody>
	              </table>
								<br>
	            </div>
	          </div><!-- /.panel-body-->
	        </div><!-- /.panel-->
	      </div><!-- /.col-->
	    </div><!-- /.row-->

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

		<script type="text/javascript">
			$(document).ready( function () {
				$('table').DataTable({
					order: [[0, 'asc'],[1, 'desc']],
				});
			});
		</script>

		<!--javascript source-->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/easypiechart.js"></script>
		<script src="js/easypiechart-data.js"></script>
		<script src="js/custom.js"></script>

	</body>
	<!--end of body-->

	</html>
	<!--end of html-->

<?php
}
?>
