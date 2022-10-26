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
	$businessID = $_SESSION['ASportBusinessSessionCounter'];
	$businessFacilityID = $_GET['businessFacilityID'];

	$sql = "DELETE FROM businessFacility WHERE businessFacilityID='$businessFacilityID' AND businessID='$businessID'";
	$result = mysqli_query($con,$sql);

	// JAVASCRIPT ALERT STATUS
	//
	// Facility Add Status
	if($result){
		echo "<script>alert('Facility has been deleted!');</script>";
		echo "<script>window.location.href='business-facilityManagement-myFacilities1.php'</script>";
	}
	else {
		echo "<script>alert('There is a problem deleting this facility. Please try again.');</script>";
	}
}
?>
