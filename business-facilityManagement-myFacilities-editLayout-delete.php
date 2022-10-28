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

	$sql = "SELECT * FROM businessFacility WHERE businessFacilityID='$businessFacilityID' AND businessID='$businessID'";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$current_layoutFileName = $data['layoutFileName'];
	}

	/* Store the path of source file */
	$sourceFilePath = $current_layoutFileName;
	/* Store the path of destination file */
	$destinationFilePath = './uploads/businessFacilityLayout/deleted/'.basename($sourceFilePath);

	//FILE DELETION
	$sqlDelete = mysqli_query($con,
		"UPDATE
			businessFacility
		SET
			layoutFileName = NULL,
			layoutFileUploadTimeStamp = NULL,
			timeStampEdited = now()
		WHERE
			businessFacilityID = '$businessFacilityID'
			AND
			businessID = '$businessID'
		");

	// JAVASCRIPT ALERT STATUS
	if($sqlDelete){
		$statusMsg = 'Facility layout file path has been deleted from database.';
		echo "<script>alert('$statusMsg');</script>";

		//move image file from existing folder (./uploads/) to deleted folder (./uploads/deleted)
		if(rename($sourceFilePath, $destinationFilePath)) {
			$statusMsg = 'File has been moved to the deleted folder at '.$destinationFilePath.'';
			echo "<script>alert('$statusMsg');</script>";
		}
		else {
			$statusMsg = 'There is a problem moving this file into the deleted folder. Please try again.';
			echo "<script>alert('$statusMsg');</script>";
		}
	}
	else {
		$statusMsg = 'There is a problem deleting this facility layout. Please try again.';
		echo "<script>alert('$statusMsg');</script>";
	}
	echo "<script>window.location.href='business-facilityManagement-myFacilities-editLayout.php?businessFacilityID=$businessFacilityID'</script>";
}
?>
