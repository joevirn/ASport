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

	//GET CURRENT FACILITY LAYOUT FILE PATH
	$sqlGetFacilityLayout = "SELECT * FROM businessFacility WHERE businessFacilityID='$businessFacilityID' AND businessID='$businessID'";
	$facilityLayoutResult = mysqli_query($con,$sqlGetFacilityLayout);
	while ($data = $facilityLayoutResult->fetch_assoc()){
		$current_layoutFileName = $data['layoutFileName'];
	}

	//IF FILE PRESENT, DELETE FACILITY LAYOUT IMAGE FILE BY DELETING PATH FROM DATABASE & MOVING TO THE FILE TO DELETED FOLDER
	if ($current_layoutFileName) {
		/* Store the path of source file */
		$sourceFilePath = $current_layoutFileName;
		/* Store the path of destination file */
		$destinationFilePath = './uploads/businessFacilityLayout/deleted/'.basename($sourceFilePath);
		//FILE DELETION QUERY
		$sqlDeleteFacilityLayout = mysqli_query($con,
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
		if($sqlDeleteFacilityLayout){
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
	}

	//DELETE FACILITY BASED ON FACILITY ID
	$sqlDeleteFacility = "DELETE FROM businessFacility WHERE businessFacilityID='$businessFacilityID' AND businessID='$businessID'";
	$deleteResult = mysqli_query($con,$sqlDeleteFacility);
	// JAVASCRIPT ALERT STATUS
	if($deleteResult){
		echo "<script>alert('Facility has been deleted!');</script>";
		echo "<script>window.location.href='business-facilityManagement-myFacilities1.php'</script>";
	}
	else {
		echo "<script>alert('There is a problem deleting this facility. Please try again.');</script>";
	}
}
?>
