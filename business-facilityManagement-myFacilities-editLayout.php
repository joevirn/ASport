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
		$businessFacilityID = $data['businessFacilityID'];
		$businessFacilityCategoryID = $data['businessFacilityCategoryID'];

		$current_layoutFileName = $data['layoutFileName'];
		$current_layoutFileUploadTimeStamp = $data['layoutFileUploadTimeStamp'];
		$current_layoutFileType = pathinfo($current_layoutFileName,PATHINFO_EXTENSION);
	}

	$sql = "SELECT * FROM businessFacilityCategories WHERE businessFacilityCategoryID='$businessFacilityCategoryID'";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$categoryName = $data['categoryName'];
	}

	//FILE UPLOAD
	if(isset($_POST["upload"])){
		$targetDir = "./uploads/";
		$layoutFileName = $_FILES["file"]["name"];
		$tempName = $_FILES["file"]["tmp_name"];
		$targetFilePath = $targetDir . $businessFacilityID . "-" .$layoutFileName;
		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		if (!empty($layoutFileName)) {
			// Allow certain file formats
	    $allowTypes = array('jpg','png','jpeg');
	    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($tempName, $targetFilePath)){
          // Insert image file name into database
					$sqlUpload = mysqli_query($con,
						"UPDATE
							businessFacility
						SET
							layoutFileName = '$targetFilePath',
							layoutFileUploadTimeStamp = now(),
							timeStampEdited = now()
						WHERE
							businessFacilityID = '$businessFacilityID'
							AND
							businessID = '$businessID'
						");
          if($sqlUpload){
						//check if there is an existing layout file
						if ($current_layoutFileName) {
							//store the path of source file
							$sourceFilePath = $current_layoutFileName;
							//Store the path of destination file
							$destinationFilePath = './uploads/deleted/'.basename($sourceFilePath);
							//move image file from existing folder (./uploads/) to deleted folder (./uploads/deleted)
							if(rename($sourceFilePath, $destinationFilePath)) {
								$statusMsg = 'Existing facility layout file has been moved to the deleted folder at '.$destinationFilePath.'';
								echo "<script>alert('$statusMsg');</script>";
							}
							else {
								$statusMsg = 'There is a problem moving existing layout file into the deleted folder. Please try again.';
								echo "<script>alert('$statusMsg');</script>";
							}
						}
            $statusMsg = "New image file \'".$layoutFileName."\' has been uploaded successfully.";
						echo "<script>alert('$statusMsg');</script>";
						echo "<script>window.location.href='business-facilityManagement-myFacilities-editLayout.php?businessFacilityID=$businessFacilityID'</script>";
          }
					else{
            $statusMsg = "Image file upload failed, please try again.";
						echo "<script>alert('$statusMsg');</script>";
          }
        }
				else{
          $statusMsg = "Sorry, there was an error uploading your image file.";
					echo "<script>alert('$statusMsg');</script>";
        }
	    }
			else{
				$statusMsg = 'Sorry, only JPG, JPEG, PNG files are allowed to upload.';
				echo "<script>alert('$statusMsg');</script>";
	    }
		}
		else{
				$statusMsg = 'Please select a file to upload.';
				echo "<script>alert('$statusMsg');</script>";
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
		<title>ASport for Business | Edit Facility Information</title>
		<?php
	  include('includes/business-head-styles.php');
	  ?>

		<style>
			table {
			  font-family: arial, sans-serif;
			  border-collapse: collapse;
			  width: 100%;
			}
			td, th {
			  border: 1px solid #dddddd;
				text-align: center;
			  padding: 8px;
			}
		</style>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'My Facilities');
		include_once('includes/business-header.php');
		include_once('includes/business-sidebar.php');
		?>

		<!--start of division class 1-->
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<!--start of division class 2-->
			<div class="row">
				<!--start of ordered list-->
				<ol class="breadcrumb">
					<!--start of list-->
					<li><a href="business-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Facility Management -> My Facilities -> <?php echo $categoryName ?> -> Edit Facility Layout</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Edit Facility Layout</div>
					</div>
				</div>
			</div>

			<div class="row">
				<?php
				$sql = "SELECT * FROM businessFacility WHERE businessID='$businessID' AND businessFacilityID='$businessFacilityID'";
				$result = mysqli_query($con,$sql);

				while ($column = $result->fetch_array()){
					$businessFacilityID = $column['businessFacilityID'];
					$businessFacilityCategoryID = $column['businessFacilityCategoryID'];
				?>
					<?php if ($businessFacilityCategoryID==1) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Badminton</b></h4>
										<p><img src="images/badminton.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==2) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Basketball</b></h4>
										<p><img src="images/basketball.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==3) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Football</b></h4>
										<p><img src="images/football.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==4) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Futsal</b></h4>
										<p><img src="images/futsal.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==5) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Squash</b></h4>
										<p><img src="images/squash.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
					<?php if ($businessFacilityCategoryID==6) { ?>
						<div class="col-md-12">
							<a href="business-facilityManagement-myFacilities2.php?businessFacilityID=<?php echo $businessFacilityID ?>">
								<div class="panel panel-default">
									<div class="panel-body easypiechart-panel">
										<h3><b>Tennis</b></h4>
										<p><img src="images/tennis.png" width="200" height="200"></p>
									</div><!-- /.panel-body-->
								</div><!-- /.panel-->
							</a>
						</div><!-- /.col-->
					<?php } ?>
				<?php
				}
				?>
				<div class="col-md-7">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>ADD / CHANGE</b><br>Facility Layout</h3><br>
							<form method="post" action="" enctype="multipart/form-data">
								<center>
									<div class="form-group">
										<label><span class="fa fa-file"></span>&nbsp Image File<br>(Accepted File Format: png, jpg, jpeg)</label><br>
										<input type="file" name="file">
									</div>
								</center>
								<br>
								<div style="text-align: center;" class="form-group has-success">
									<button type="submit" name="upload" class="btn btn-primary" ><i class="fa fa-upload fa-lg"></i>&nbsp UPLOAD IMAGE</button>
								</div><br>
							</form>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-5">
					<form method="post" action="">
						<a href="business-facilityManagement-myFacilities-editLayout-delete.php?businessFacilityID=<?php echo "$businessFacilityID";?>" onclick="return confirm('Are you sure to delete this facility layout? This action cannot be reverted!')">
							<div class="panel panel-default">
								<div class="panel-body easypiechart-panel">
									<h3><b>DELETE</b><br>Current Facility Layout</h3>
									<br><p><img src="images/delete.png" width="150" height="150"></p><br>
								</div><!-- /.panel-body-->
							</div><!-- /.panel-->
						</a>
				</form>
				</div><!-- /.col-->
			</div><!-- /.row-->


			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
	            <h3 align="center"><b>Current Facility Layout</b></h3>
	              <div class="col-md-1"></div>
	  						<div class="col-md-10"><br>
									<?php if ($current_layoutFileName): ?>
										<table id="facilityLayout_table" class="table table-stripped table-hover table-bordered">
											<thead>
												<tr>
													<th id="FileName" style="width:5%;"><span class="fa fa-file"></span>&nbsp File Path Name</th>
													<th id="Format" style="width:5%;"><span class="fa fa-file-image-o"></span>&nbsp File Format</th>
													<th id="DateUploaded" style="width:5%;"><span class="fa fa-file-text-o"></span>&nbsp Uploaded Time Stamp</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th id="FileName" style="width:5%;"><?php echo $current_layoutFileName ?></th>
													<td id="Format" style="width:5%;"><?php echo $current_layoutFileType ?></td>
													<td id="DateUploaded" style="width:5%;"><?php echo $current_layoutFileUploadTimeStamp ?></td>
												</tr>
											</tbody>
										</table>
										<br>
										<center><img src="<?php echo $current_layoutFileName; ?>" width="100%" height="100%" style="border: 1px solid"></center><br><br>
										<form method="post" action="" enctype="multipart/form-data">
											<div style="text-align: center;" class="form-group has-success">
												<a href="<?php echo $current_layoutFileName; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-download fa-lg"></i>&nbsp VIEW FULL IMAGE</a>
											</div>
										</form>
									<?php else: ?>
										<center><img src="images/business/icon-noImageAvailable.png" width="50%" height="50%"></center>
									<?php endif; ?>
									<br><br>
								<div class="col-md-1"></div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row-->

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
