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
		<title>ASport | Past Bookings</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<link rel="icon" type="image/png" href="images/ASport.png" sizes="113x113" >

		<!--Custom Font-->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Past');
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
					<li class="active">My Bookings -> Past</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Past Bookings</div>
					</div>
				</div>
			</div>

			<div class="row">
	      <div class="col-md-12">
	        <div class="panel panel-default">
	          <div class="panel-body easypiechart-panel">
	            <h3><b>Past Bookings</b></h3>
	            <h3><b><font color="blue"><?php echo "$header" ?></font></b></h3>
	            <div class="easypiechart" id="easypiechart-blue" data-percent="100" >
	              <span class="percent">
	                <?php echo "$count" ?>
	              </span>
	            </div>
	            <br>
	            <div class="col-md-12">
	              <table id="editable_table" class="table table-bordered table-striped">
	                <h4 align="left"><font color="#30a5ff"><span class="fa fa-search"></span></font>&nbsp &nbsp<tt><input id="myInput" type="text" placeholder="Search.."></tt></h4>
	                <thead>
										<tr>
											<th width="10%">&nbsp <span class="fa fa-id-card-o"></span>&nbsp Booking ID</th>
	                    <th width="10%">&nbsp <span class="fa fa-calendar"></span>&nbsp Date</th>
											<th width="10%">&nbsp <span class="fa fa-clock-o"></span>&nbsp Start Time</th>
											<th width="10%">&nbsp <span class="fa fa-clock-o"></span>&nbsp End Time</th>
											<th width="10%">&nbsp <span class="fa fa-list"></span>&nbsp Duration (Hours)</th>
											<th width="10%">&nbsp <span class="fa fa-location-arrow"></span>&nbsp Venue</th>
	                    <th width="10%">&nbsp <span class="fa fa-th-large"></span>&nbsp Category</th>
											<th width="10%">&nbsp <span class="fa fa-info-circle"></span>&nbsp Facility No</th>
											<th width="10%">&nbsp <span class="fa fa-money"></span>&nbsp Price (RM)</th>
	                  </tr>
	                </thead>
	                <tbody id="myTable">
	                  <?php
	                  foreach ($filter as $row) {
	                  ?>
	                    <tr>
						            <td><?php echo $row['bookingID'];?></td>
	                      <td><?php echo $row[''];?></td>
	                      <td><?php echo $row[''];?></td>
	                      <td><?php echo $row[''];?></td>
	                      <td><?php echo $row[''];?></td>
	                    </tr>
	                  <?php
	                  }
	                  ?>
	                </tbody>
	              </table>
	            </div>
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
