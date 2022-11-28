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
	$userBookingID = $_GET['userBookingID'];

	//DELETE THE BOOKING BY SETTING bookingIsCancelled BOOLEAN
	$sql = mysqli_query($con,
	"UPDATE userBookings SET bookingIsCancelled=1, bookingIsCancelledTimeStamp=now() WHERE userID='$userID' AND userBookingID='$userBookingID'");

	//JAVASCRIPT ALERT STATUS
	//Facility Add Status
	if($sql){
		echo "<script>alert('Cancellation successfull! You will be refunded to the payment method used within 7 working days.');</script>";

		//GET THE LOYALTY TRANSACTION ID
		$sql1 = "SELECT * FROM userBookings WHERE userBookingID='$userBookingID'";
		$result1 = mysqli_query($con,$sql1);
		while ($data = $result1->fetch_assoc()){
			$userLoyaltyTransactionID = $data['userLoyaltyTransactionID'];
		}

		//GET THE CURRENT POINTS ADDED
		$sql2 = "SELECT * FROM userLoyaltyTransactions WHERE userLoyaltyTransactionID='$userLoyaltyTransactionID' AND userBookingID='$userBookingID' AND pointsDeductedAmount IS NULL";
		$result2 = mysqli_query($con,$sql2);
		while ($data = $result2->fetch_assoc()){
			$pointsDeductedAmount = $data['pointsAddedAmount'];
		}

		//GET LATEST POINTS BALANCE
		$sql3 = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID ORDER BY userLoyaltyTransactionID DESC LIMIT 1";
		$result3 = mysqli_query($con,$sql3);
		while ($data = $result3->fetch_assoc()){
			$pointsBalance = $data['pointsBalance'];
		}
		$newPointsBalance = $pointsBalance - $pointsDeductedAmount;

		//ADD LOYALTY POINTS DEDUCTION TO CURRENT BOOKING ID
		$sqlDeductLoyaltyPoints = mysqli_query($con,
			"INSERT INTO userLoyaltyTransactions(userID, userBookingID, pointsDeductedAmount, pointsBalance)
				VALUE          									('$userID', '$userBookingID', '$pointsDeductedAmount', '$newPointsBalance')
			");
		if($sqlDeductLoyaltyPoints){
			echo "<script>alert('Loyalty points successfully deducted for this booking!');</script>";
		}
		else {
			echo "<script>alert('There is a problem deducting loyalty points for this transaction. Please contact customer service.');</script>";
		}

	}

	else {
		echo "<script>alert('There is a problem cancelling this booking. Please try again.');</script>";
	}

	echo "<script>window.location.href='user-bookings-receipt.php?userBookingID=$userBookingID'</script>";
}
?>
