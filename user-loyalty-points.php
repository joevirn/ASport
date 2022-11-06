<?php
//start the session
session_start();
error_reporting(0);
//connect to database
include('includes/dbconnection.php');

//if the user id in the session is being cleared, log out the user
if (strlen($_SESSION['ASportUserSessionCounter'] == 0)) {
	header('location:user-logout.php');
}
else {
	$userID = $_SESSION['ASportUserSessionCounter'];

	//GET PONTS BALANCE
	$sql = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID ORDER BY userLoyaltyTransactionID DESC LIMIT 1";
	$result = mysqli_query($con,$sql);
	while ($row = $result->fetch_assoc()){
		$current_pointsBalance = $row['pointsBalance'];
	}

	//GET TOTAL POINTS COLLECTED & USED
	$sql = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID";
	$result = mysqli_query($con,$sql);
	while ($row = $result->fetch_assoc()){
		$current_pointsAdded = $row['pointsAddedAmount'];
		$current_pointsDeducted = $row['pointsDeductedAmount'];

		$current_totalPointsAdded += $current_pointsAdded;
		$current_totalPointsDeducted+= $current_pointsDeducted;
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
		<title>ASport | Loyalty Points</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
		<!-- for data tables -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
	</head>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Points');
		include_once('includes/user-header.php');
		include_once('includes/user-sidebar.php');
		?>

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="user-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Loyalty -> Points</li>
				</ol>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Loyalty Points</div>
					</div>
				</div>
			</div>

      <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-star"></span><br>Points Balance</b></h3>
							<center>
								<table>
								<tr>
									<td><img src="images/loyalty.png" width="100" height="100">&nbsp &nbsp &nbsp &nbsp</td>
									<td>
										<div class="easypiechart" id="easypiechart-blue" data-percent="100" >
											<span class="percent"><?php echo $current_pointsBalance ?></span>
										</div>
									</td>
								</tr>
							</table>
						</center>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-plus"></span><br>Total Points Earned</b></h3>
							<center>
								<table>
								<tr>
									<td><img src="images/plus.png" width="100" height="100">&nbsp &nbsp &nbsp &nbsp</td>
									<td>
										<div class="easypiechart" id="easypiechart-teal" data-percent="100" >
											<span class="percent"><?php echo $current_totalPointsAdded ?></span>
										</div>
									</td>
								</tr>
							</table>
						</center>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-minus"></span><br>Total Points Deducted</b></h3>
							<center>
								<table>
								<tr>
									<td><img src="images/minus.png" width="100" height="100">&nbsp &nbsp &nbsp &nbsp</td>
									<td>
										<div class="easypiechart" id="easypiechart-red" data-percent="100" >
											<span class="percent"><?php echo $current_totalPointsDeducted ?></span>
										</div>
									</td>
								</tr>
							</table>
						</center>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div>

			<div class="row">
	      <div class="col-md-12">
	        <div class="panel panel-default">
	          <div class="panel-body easypiechart-panel"><br>
	            <h3><b><span class="fa fa-history"></span>&nbsp Transaction History</b></h3>
	            <br>
	            <div class="col-md-12">
	              <table class="table table-bordered table-striped" id="transactionHistory">
	                <thead>
	                  <tr>
	                    <th style="text-align: center"><span class="fa fa-calendar"></span><br>Date & Time</th>
											<th style="text-align: center"><span class="fa fa-star"></span><br>Points Balance</th>
											<th style="text-align: center"><span class="fa fa-plus"></span><br>Points Added Amount</th>
											<th style="text-align: center"><span class="fa fa-ticket"></span><br>Booking ID</th>
											<th style="text-align: center"><span class="fa fa-minus"></span><br>Points Deducted Amount</th>
											<th style="text-align: center"><span class="fa fa-gift"></span><br>Rewards Voucher ID</th>
	                  </tr>
	                </thead>
	                <tbody>
	                  <?php
										$sql = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID";
										$result = mysqli_query($con,$sql);
										while ($row = $result->fetch_assoc()){
	                  ?>
	                    <tr>
	                      <td><b><?php echo $row['pointsChangeTimeStamp'];?></b></td>
												<td><b><?php echo $row['pointsBalance'];?></b></td>
	                      <td><?php echo $row['pointsAddedAmount'];?></td>
												<td><a target="_blank" href="user-bookings-receipt.php?userBookingID=<?php echo $row['userBookingID'];?>"><?php echo $row['userBookingID'];?></a></td>
	                      <td><?php echo $row['pointsDeductedAmount'];?></td>
												<td><a target="_blank" href="user-loyalty-rewards.php?userRewardsVoucherID=<?php echo $row['userRewardsVoucherID'];?>"><?php echo $row['userRewardsVoucherID'];?></a></td>
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
				$('#transactionHistory').DataTable({
					order: [[0, 'desc']],
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
