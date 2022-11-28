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
	$businessVenueImageID = $_GET['businessVenueImageID'];

	//GET CURRENT IMAGE FILE PATH
	$sqlGetCurrentImage = "SELECT * FROM businessVenueGallery WHERE businessVenueImageID='$businessVenueImageID' AND businessID='$businessID'";
	$currentImageResult = mysqli_query($con,$sqlGetCurrentImage);
	while ($data = $currentImageResult->fetch_assoc()){
		$imageFileName = $data['imageFileName'];
	}

	//IF FILE PRESENT, DELETE IMAGE FILE BY DELETING PATH FROM DATABASE & MOVING TO THE FILE TO DELETED FOLDER
	if ($imageFileName) {
		/* Store the path of source file */
		$sourceFilePath = $imageFileName;
		/* Store the path of destination file */
		$destinationFilePath = './uploads/businessGallery/deleted/'.basename($sourceFilePath);
		//FILE DELETION QUERY
		$sqlDeleteFacilityLayout = mysqli_query($con,
			"DELETE FROM
				businessVenueGallery
			WHERE
				businessVenueImageID = '$businessVenueImageID'
				AND
				businessID = '$businessID'
			");
		// JAVASCRIPT ALERT STATUS
		if($sqlDeleteFacilityLayout){
			$statusMsg = 'Image file path has been deleted from database.';
			echo "<script>alert('$statusMsg');</script>";
			//move image file from existing folder (./uploads/) to deleted folder (./uploads/deleted)
			if(rename($sourceFilePath, $destinationFilePath)) {
				$statusMsg = 'Image file has been moved to the deleted folder at '.$destinationFilePath.'';
				echo "<script>alert('$statusMsg');</script>";
				echo "<script>window.location.href='business-venueManagement-gallery.php'</script>";
			}
			else {
				$statusMsg = 'There is a problem moving this file into the deleted folder. Please try again.';
				echo "<script>alert('$statusMsg');</script>";
			}
		}
		else {
			$statusMsg = 'There is a problem deleting this image. Please try again.';
			echo "<script>alert('$statusMsg');</script>";
		}
	}
}
?>
