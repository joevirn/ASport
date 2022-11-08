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

?>

	<!DOCTYPE html>
	<!--start of html-->
	<html>

	<!--start of head-->

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--title of the webpage-->
		<title>ASport | Loyalty Rewards</title>
		<?php
	  include('includes/user-head-styles.php');
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
		define('PAGE', 'Rewards');
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
					<li class="active">Loyalty -> Rewards</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Loyalty Rewards</div>
					</div>
				</div>
			</div>

			<div class="row">
	      <div class="col-md-12">
	        <div class="panel panel-default">
	          <div class="panel-body easypiechart-panel"><br>
	            <h3><b><span class="fa fa-plus"></span><br>Vouchers Available</b></h3>
	            <br>
							<div class="col-md-1"></div>
	            <div class="col-md-10">
	              <table class="table table-bordered table-striped">
	                <thead>
	                  <tr>
	                    <th style="text-align: center"><span class="fa fa-calendar"></span><br>Voucher Issued On</th>
											<th style="text-align: center"><span class="fa fa-hourglass"></span><br>Voucher Expiry Date</th>
											<th style="text-align: center"><span class="fa fa-gift"></span><br>Voucher ID</th>
											<th style="text-align: center"><span class="fa fa-money"></span><br>Voucher Value (RM)</th>
	                  </tr>
	                </thead>
	                <tbody>
	                  <?php
										$sql = "SELECT * FROM userRewardsVouchers WHERE userID=$userID AND rewardsVoucherIsUsed IS NULL";
										$result = mysqli_query($con,$sql);
										while ($row = $result->fetch_assoc()){
	                  ?>
	                    <tr>
	                      <td><b><?php echo $row['rewardsVoucherIssuedTimeStamp'];?></b></td>
												<td><?php echo $row['rewardsVoucherExpiryDate'];?></td>
												<td><?php echo $row['userRewardsVoucherID'];?></td>
	                      <td><?php echo $row['rewardsVoucherValue'];?></td>
	                    </tr>
	                  <?php
	                  }
	                  ?>
	                </tbody>
	              </table>
								<br>
	            </div>
							<div class="col-md-1"></div>
	          </div><!-- /.panel-body-->
	        </div><!-- /.panel-->
	      </div><!-- /.col-->
	    </div><!-- /.row-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel"><br>
							<h3><b><span class="fa fa-minus"></span><br>Vouchers Used</b></h3>
							<br>
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="text-align: center"><span class="fa fa-calendar"></span><br>Voucher Used On</th>
											<th style="text-align: center"><span class="fa fa-calendar"></span><br>Voucher Issued On</th>
											<th style="text-align: center"><span class="fa fa-hourglass"></span><br>Voucher Expiry Date</th>
											<th style="text-align: center"><span class="fa fa-gift"></span><br>Voucher ID</th>
											<th style="text-align: center"><span class="fa fa-money"></span><br>Voucher Value (RM)</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT * FROM userRewardsVouchers WHERE userID=$userID AND rewardsVoucherIsUsed IS NOT NULL";
										$result = mysqli_query($con,$sql);
										while ($row = $result->fetch_assoc()){
										?>
											<tr>
												<td><b><?php echo $row['rewardsVoucherIsUsedTimeStamp'];?></b></td>
												<td><b><?php echo $row['rewardsVoucherIssuedTimeStamp'];?></b></td>
												<td><?php echo $row['rewardsVoucherExpiryDate'];?></td>
												<td><?php echo $row['userRewardsVoucherID'];?></td>
												<td><?php echo $row['rewardsVoucherValue'];?></td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<br>
							</div>
							<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-info-circle"></span><br>Voucher Terms and Conditions</b></h3>
							<br>

							<div class="col-md-1"></div>
							<div class="col-md-10">
								<h4>
								<ul>
									<li>Each voucher is valid for one-time use only.</li><br>
									<li>Voucher is non-transferable, non-refundable and non-exchangeable.</li><br>
									<li>Users can retrieve all redeemed vouchers from Loyalty -> Rewards.</li><br>
									<li>ASport reserves the right to vary and amend these terms and conditions at any time without prior notice.</li><br>
									<li>ASport reserves the sole and absolute right to alter or end this promotion, without giving prior notice, or compensation in cash or any kind.</li><br>
								</ul>
								</h4>
							</div>
							<div class="col-md-1"></div>

							<br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

		<script type="text/javascript">
			$(document).ready( function () {
				$('table').DataTable({
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
