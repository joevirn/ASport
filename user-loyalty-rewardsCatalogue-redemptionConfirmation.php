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
	$voucherAmount = $_GET['voucherAmount'];

	if ($voucherAmount==5) {
		$pointsRequired=50;
	}
	else if ($voucherAmount==10) {
		$pointsRequired=100;
	}
	else if ($voucherAmount==15) {
		$pointsRequired=150;
	}
	else if ($voucherAmount==20) {
		$pointsRequired=200;
	}
	//GET PONTS BALANCE
	$sql = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID ORDER BY userLoyaltyTransactionID DESC LIMIT 1";
	$result = mysqli_query($con,$sql);
	while ($row = $result->fetch_assoc()){
		$current_pointsBalance = $row['pointsBalance'];
	}
	$newPointsBalance = $current_pointsBalance - $pointsRequired;


	if(isset($_POST['submit']))
	{
		//GENERATE REWARDS VOUCHER
		$sqlAddRewardsVoucher = mysqli_query($con,
			"INSERT INTO userRewardsVouchers(userID, rewardsVoucherValue, rewardsVoucherIssuedTimeStamp)
			 VALUE            							('$userID', '$voucherAmount', now())
			");
		//JAVASCRIPT ALERT STATUS
		//Facility Add Status
		if($sqlAddRewardsVoucher){
			echo "<script>alert('Rewards voucher has been successfully generated!');</script>";

			//GET PONTS BALANCE
			$sql = "SELECT * FROM userRewardsVouchers WHERE userID=$userID ORDER BY userRewardsVoucherID DESC LIMIT 1";
			$result = mysqli_query($con,$sql);
			while ($row = $result->fetch_assoc()){
				$userRewardsVoucherID = $row['userRewardsVoucherID'];
			}

			//ADD A NEW LOYALTY TRANSACTION TO DEDUCT POINTS ACCORDINGLY
		  $sqlAddLoyaltyTransaction = mysqli_query($con,
		    "INSERT INTO userLoyaltyTransactions(userID, userRewardsVoucherID, pointsBalance, pointsDeductedAmount)
		     VALUE            									('$userID', '$userRewardsVoucherID', '$newPointsBalance', '$pointsRequired')
				");

			//JAVASCRIPT ALERT STATUS
			//Facility Add Status
		  if($sqlAddLoyaltyTransaction){
				//GET LOYALTY TRANSACTION POINTS ID
				$sqlGetLoyaltyTransactionID = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID ORDER BY userLoyaltyTransactionID DESC LIMIT 1";
				$result = mysqli_query($con,$sqlGetLoyaltyTransactionID);
				while ($data = $result->fetch_assoc()){
					$userLoyaltyTransactionID = $data['userLoyaltyTransactionID'];
				}

				//LINK LOYALTY TRANSACTION POINTS ID TO CURRENT BOOKING ID
				$sqlLinkLoyaltyPoints = mysqli_query($con,
				"UPDATE userRewardsVouchers
				SET userLoyaltyTransactionID = $userLoyaltyTransactionID
				WHERE userRewardsVoucherID = $userRewardsVoucherID");

				if($sqlLinkLoyaltyPoints){
					echo "<script>alert('Loyalty points has been deducted for this transaction!');</script>";
					echo "<script>window.location.href='user-loyalty-rewards.php'</script>";
				}
				else {
					echo "<script>alert('There is a problem with loyalty points linking. Please contact customer service.');</script>";
				}
		  }
			else {
				echo "<script>alert('There is a problem deducting your loyalty points. Please try again.');</script>";
			}
		}
		else {
			echo "<script>alert('There is a problem generating rewards voucher. Please try again.');</script>";
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
						<div class="panel-heading">Loyalty Rewards Redemption Confirmation</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-star"></span><br>Your Current Points Balance</b></h3>
							<center>
								<table>
								<tr>
									<td><img src="images/loyalty.png" width="100" height="100">&nbsp &nbsp &nbsp &nbsp</td>
									<td>
										<div class="easypiechart" id="easypiechart-teal" data-percent="100" >
											<span class="percent"><?php echo $current_pointsBalance ?></span>
										</div>
									</td>
								</tr>
							</table>
						</center>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-minus"></span><br>Points to Be Deducted</b></h3>
							<center>
								<table>
								<tr>
									<td><img src="images/minus.png" width="100" height="100">&nbsp &nbsp &nbsp &nbsp</td>
									<td>
										<div class="easypiechart" id="easypiechart-red" data-percent="100" >
											<span class="percent"><?php echo $pointsRequired ?></span>
										</div>
									</td>
								</tr>
							</table>
						</center>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-star"></span><br>Your New Points Balance</b></h3>
							<center>
								<table>
								<tr>
									<td><img src="images/loyalty.png" width="100" height="100">&nbsp &nbsp &nbsp &nbsp</td>
									<td>
										<div class="easypiechart" id="easypiechart-blue" data-percent="100" >
											<span class="percent"><?php echo $newPointsBalance ?></span>
										</div>
									</td>
								</tr>
							</table>
						</center>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->

			<form method="post" action="">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-money"></span><br>ASport RM<?php echo $voucherAmount ?> Voucher</b></h3>
							<h3>Points Required :<br><font color="blue"><b><?php echo $pointsRequired ?></b></font></h3><br>
							<button type="submit" class="btn btn-primary" name="submit" style="width: 30%;"><b>CONFIRM REDEMPTION</b></button>
							<br><br>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->
			</form>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b><span class="fa fa-info"></span><br>Voucher Terms and Conditions</b></h3>
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
