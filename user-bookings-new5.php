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

	if(isset($_POST['submit'])){

		// //prepare and bind
		// $statement = $conn->prepare("INSERT INTO userBookings(userID, businessFacilityID,
		// 														bookingDate, bookingStartTime, bookingEndTime, bookingDuration,
		// 														bookingVenue, bookingCategory, bookingFacilityNo, bookingPrice)
		//                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		// $statement->bind_param("ssssssssid",
		// 												$userID, $businessFacilityID,
		// 												$bookingDate, $bookingStartTime,$bookingEndTime, $bookingDuration,
		// 												$bookingVenue, $bookingCategory, $bookingFacilityNo, $bookingPrice);
		//
		// $userID = $_SESSION['ASportUserSessionCounter'];				

		// //execute parameters
		// $statement->execute();
		//
		// //close
		// $statement->close();


		$businessFacilityID = $_POST['businessFacilityID'];

		$bookingDate = $_POST['bookingDate'];
		$bookingStartTime = $_POST['bookingStartTime'];
		$bookingEndTime = $_POST['bookingEndTime'];
		$bookingDuration = $_POST['bookingDuration'];
		$bookingVenue = $_POST['bookingVenue'];
		$bookingCategory = $_POST['bookingCategory'];
		$bookingFacilityNo = $_POST['bookingFacilityNo'];
		$bookingPrice = $_POST['bookingPrice'];

		$bookingLoyaltyPoints = $_POST['bookingLoyaltyPoints'];

		//ADD NEW BOOKING
		$sqlAdd = mysqli_query($con,
			"INSERT INTO userBookings(userID, businessFacilityID,
																bookingDate, bookingStartTime, bookingEndTime, bookingDuration,
																bookingVenue, bookingCategory, bookingFacilityNo, bookingPrice)
	 		VALUE          					('$userID', '$businessFacilityID',
															 '$bookingDate', '$bookingStartTime', '$bookingEndTime', '$bookingDuration',
															 '$bookingVenue', '$bookingCategory', '$bookingFacilityNo', '$bookingPrice')
			");

		//JAVASCRIPT ALERT STATUS
		//Facility Add Status
		if($sqlAdd){
			echo "<script>alert('Booking successfull!');</script>";
			//GET THE CURRENT BOOKING ID
			$sql = "SELECT * FROM userBookings ORDER BY userBookingID DESC LIMIT 1";
			$result = mysqli_query($con,$sql);
			while ($data = $result->fetch_assoc()){
				$userBookingID = $data['userBookingID'];
			}

			//GET LATEST BALANCE
			$sqlGetLoyaltyPoints = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID ORDER BY userLoyaltyTransactionID DESC LIMIT 1";
			$result = mysqli_query($con,$sqlGetLoyaltyPoints);
			while ($data = $result->fetch_assoc()){
				$pointsBalance = $data['pointsBalance'];
			}

			$newPointsBalance = $pointsBalance + $bookingLoyaltyPoints;

			//ADD LOYALTY POINTS TO CURRENT BOOKING ID
			$sqlAddLoyaltyPoints = mysqli_query($con,
				"INSERT INTO userLoyaltyTransactions(userID, userBookingID, pointsAddedAmount, pointsBalance)
		 			VALUE          									('$userID', '$userBookingID', '$bookingLoyaltyPoints', '$newPointsBalance')
				");

			if($sqlAddLoyaltyPoints){
				//GET LOYALTY TRANSACTION POINTS ID
				$sqlGetLoyaltyTransactionID = "SELECT * FROM userLoyaltyTransactions WHERE userID=$userID ORDER BY userLoyaltyTransactionID DESC LIMIT 1";
				$result = mysqli_query($con,$sqlGetLoyaltyTransactionID);
				while ($data = $result->fetch_assoc()){
					$userLoyaltyTransactionID = $data['userLoyaltyTransactionID'];
				}

				//LINK LOYALTY TRANSACTION POINTS ID TO CURRENT BOOKING ID
				$sqlLinkLoyaltyPoints = mysqli_query($con,
				"UPDATE userBookings
				SET userLoyaltyTransactionID = $userLoyaltyTransactionID
				WHERE userBookingID = $userBookingID");

				if($sqlLinkLoyaltyPoints){
					echo "<script>alert('Loyalty points successfully added for this transaction!');</script>";
					echo "<script>window.location.href='user-bookings-receipt.php?userBookingID=$userBookingID'</script>";
				}
				else {
					echo "<script>alert('There is a problem adding loyalty points for this transaction. Please contact customer service.');</script>";
					echo "<script>alert('$userLoyaltyTransactionID $userBookingID')</script>";
				}
			}
			else {
				echo "<script>alert('There is a problem adding loyalty points for this transaction. Please contact customer service.');</script>";
				echo "<script>window.location.href='user-dashboard.php'</script>";
			}

		}
		else {
			echo "<script>alert('There is a problem making this booking. Please try again.');</script>";
			echo "<script>window.location.href='user-dashboard.php'</script>";
		}
	}
}
?>
