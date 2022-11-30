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
	if (mysqli_num_rows($result) == 0) {
		$current_pointsBalance = 0;
	}
	else {
		while ($row = $result->fetch_assoc()){
			$current_pointsBalance = $row['pointsBalance'];
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
		<title>ASport | Loyalty Rewards Catalogue</title>
		<?php
	  include('includes/user-head-styles.php');
	  ?>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Rewards Catalogue');
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
					<li class="active">Loyalty -> Rewards Catalogue</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Loyalty Rewards Catalogue</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-star"></span><br>Your Latest Points Balance</b></h3>
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
  		</div><!-- /.row -->

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-money"></span><br>ASport RM5 Voucher</b></h3>
							<h3>Points Required :<br><font color="blue"><b>50</b></font></h3>
							<h4>Voucher Validity : <b><br>30 days</b></h4><br>
							<?php if ($current_pointsBalance>50): ?>
								<a href="user-loyalty-rewardsCatalogue-redemptionConfirmation.php?voucherAmount=5"><button type="submit" class="btn btn-primary" name="submit" style="width: 30%;"><b>REDEEM</b></button></a>
							<?php else: ?>
								<button class="btn btn-warning" style="width: 55%;" disabled><b>INSUFFICIENT POINTS BALANCE</b></button>
							<?php endif; ?>
							<br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-money"></span><br>ASport RM10 Voucher</b></h3>
							<h3>Points Required :<br><font color="blue"><b>100</b></font></h3>
							<h4>Voucher Validity : <b><br>30 days</b></h4><br>
							<?php if ($current_pointsBalance>100): ?>
								<a href="user-loyalty-rewardsCatalogue-redemptionConfirmation.php?voucherAmount=10"><button type="submit" class="btn btn-primary" name="submit" style="width: 30%;"><b>REDEEM</b></button></a>
							<?php else: ?>
								<button class="btn btn-warning" style="width: 55%;" disabled><b>INSUFFICIENT POINTS BALANCE</b></button>
							<?php endif; ?>
							<br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-money"></span><br>ASport RM15 Voucher</b></h3>
							<h3>Points Required :<br><font color="blue"><b>150</b></font></h3>
							<h4>Voucher Validity : <b><br>30 days</b></h4><br>
							<?php if ($current_pointsBalance>150): ?>
								<a href="user-loyalty-rewardsCatalogue-redemptionConfirmation.php?voucherAmount=15"><button type="submit" class="btn btn-primary" name="submit" style="width: 30%;"><b>REDEEM</b></button></a>
							<?php else: ?>
								<button class="btn btn-warning" style="width: 55%;" disabled><b>INSUFFICIENT POINTS BALANCE</b></button>
							<?php endif; ?>
							<br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-money"></span><br>ASport RM20 Voucher</b></h3>
							<h3>Points Required :<br><font color="blue"><b>200</b></font></h3>
							<h4>Voucher Validity : <b><br>30 days</b></h4><br>
							<?php if ($current_pointsBalance>200): ?>
								<a href="user-loyalty-rewardsCatalogue-redemptionConfirmation.php?voucherAmount=20"><button type="submit" class="btn btn-primary" name="submit" style="width: 30%;"><b>REDEEM</b></button></a>
							<?php else: ?>
								<button class="btn btn-warning" style="width: 55%;" disabled><b>INSUFFICIENT POINTS BALANCE</b></button>
							<?php endif; ?>
							<br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->

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
