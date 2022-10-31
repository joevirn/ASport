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

	//FILE UPLOAD
	if(isset($_POST["upload"])){
		$imageDescription = $_POST['imageDescription'];
		$imagePosition = 1;

		$targetDir = "./uploads/businessGallery/";
		$imageFileName = $_FILES["file"]["name"];
		$tempName = $_FILES["file"]["tmp_name"];
		$targetFilePath = $targetDir . $businessID . "-" .$imageFileName;
		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		if (!empty($imageFileName)) {
			// Allow certain file formats
			$allowTypes = array('jpg','png','jpeg');
			if(in_array($fileType, $allowTypes)){
				// Upload file to server
				if(move_uploaded_file($tempName, $targetFilePath)){
					$sqlUpload = mysqli_query($con,
						"INSERT INTO businessVenueGallery(businessID, imageFileName, imageDescription, imagePosition)
						 VALUE            							('$businessID', '$targetFilePath', '$imageDescription', '$imagePosition')
						");
					if($sqlUpload){
						$statusMsg = "New image file \'".$imageFileName."\' has been uploaded successfully.";
						echo "<script>alert('$statusMsg');</script>";
						echo "<script>window.location.href='business-venueManagement-gallery.php'</script>";
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
		<title>ASport for Business | Gallery</title>
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
			.available {
				background-color: white;
			}
			td:hover.available{
		   cursor: pointer;
		   background-color: #30a5ff;
		 	}
			.booked {
				background-color: lightgray;
			}
			.locked {
				background-color: gray;
			}
			.selection {
				background-color: #30a5ff;
			}
      .panel-body input[type=checkbox]:checked + label {
        text-decoration: underline;
        color: #777;
      }
		</style>
	</head>
	<!--end of head-->

	<!--start of body-->

	<body>
		<?php
		//include the header and the sidebar
		define('PAGE', 'Gallery');
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
					<li class="active">Venue Management -> Gallery</li>
					<!--end of list-->
				</ol>
				<!--end of ordered list-->
			</div>
			<!--end of division class 2-->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Gallery</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>ADD</b><br>A New Image</h3><br>
							<form method="post" action="" enctype="multipart/form-data">
								<center>
									<div class="form-group">
										<label><span class="fa fa-file"></span>&nbsp Image File<br>(Accepted File Format: png, jpg, jpeg)</label><br>
										<input type="file" name="file">
									</div><br>
									<div class="row">
										<div class="col-md-3"></div>
										<div class="col-md-6">
											<div class="form-group">
												<label><span class="fa fa-sticky-note-o"></span>&nbsp Image Description</label>
												<input type="text" name="imageDescription" class="form-control" required="true">
											</div>
										</div>
										<div class="col-md-3"></div>
									</div><br>
									<div style="text-align: center;" class="form-group has-success">
										<button type="submit" name="upload" class="btn btn-primary" ><i class="fa fa-upload fa-lg"></i>&nbsp UPLOAD IMAGE</button>
									</div><br>
								</center>
							</form>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>EDIT</b><br>Description & Position of Existing Images</h3>
								<div class="col-md-12"><br>
									<table id="imageFiles_table" class="table table-stripped table-hover table-bordered">
										<thead>
											<tr>
												<th id="FileName" style="width:5%;"><span class="fa fa-file"></span>&nbsp File Path Name</th>
												<th id="Format" style="width:5%;"><span class="fa fa-file-image-o"></span>&nbsp File Format</th>
												<th id="Description" style="width:5%;"><span class="fa fa-sticky-note-o"></span>&nbsp Description</th>
												<th id="DateUploaded" style="width:5%;"><span class="fa fa-upload"></span>&nbsp Uploaded On</th>
												<th id="DateUploaded" style="width:5%;"><span class="fa fa-pencil"></span>&nbsp Edited On</th>
												<th id="View" style="width:5%;">View</th>
											</tr>
										</thead>
										<tbody class="imageFile">
											<?php
											$ret = mysqli_query($con,"SELECT * FROM businessVenueGallery WHERE businessID='$businessID' ORDER BY imagePosition");
											while ($row = mysqli_fetch_assoc($ret)) {
												$businessVenueImageID = $row['businessVenueImageID'];
												$imageFileName = $row['imageFileName'];
												$imageFileType = pathinfo($imageFileName,PATHINFO_EXTENSION);
												$imageDescription = $row['imageDescription'];
												$imagePosition = $row['imagePosition'];
												$imageFileUploadTimeStamp = $row['imageFileUploadTimeStamp'];
												$timeStampEdited = $row['timeStampEdited'];
												$identifiers = $businessVenueImageID . ";" . $businessID . ";" . $imageFileName;
											?>
												<tr data-index="<?php echo $businessVenueImageID ?>" data-position="<?php echo $imagePosition ?>">
													<td style="display: none;"><?php echo $identifiers;?></td>
													<th id="FileName" style="width:5%;"><?php echo $imageFileName ?></th>
													<td id="Format" style="width:5%;"><?php echo $imageFileType ?></td>
													<td id="Description" style="width:5%;"><?php echo $imageDescription ?></td>
													<td id="DateUploaded" style="width:5%;"><?php echo $imageFileUploadTimeStamp ?></td>
													<td id="DateUploaded" style="width:5%;"><?php echo $timeStampEdited ?></td>
													<td id="View" style="width:5%;">
														<form method="post" action="" name="viewImage" enctype="multipart/form-data">
															<a href="<?php echo $imageFileName; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-search fa-lg"></i></a>
														</form>
													</td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>VIEW</b><br>Full Gallery</h3>
								<div class="col-md-12"><br>
									<h3 align="center">"OWL COUROUSEL IMAGE VIEWER"</h3>
								</div>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div><!-- /.row -->

			<!--include the footer-->
			<?php include_once('includes/footer.php'); ?>

		</div>
		<!--end of division class 1-->

		<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
				integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
				crossorigin="anonymous">
		</script>

		<script>
			$(document).ready(function () {
				 $('.imageFile').sortable({
						 update: function (event, ui) {
								 $(this).children().each(function (index) {
											if ($(this).attr('data-position') != (index+1)) {
													$(this).attr('data-position', (index+1)).addClass('updated');
											}
								 });
								 saveNewPositionsIncome();
						 }
				 });

				 $('#imageFiles_table').Tabledit({
						url: 'exp-table-action.php',
						columns: {
							identifier: [0, 'identifiers'],
							editable: [[3, 'description']]
						},
						onDraw: function() {
							console.log('onDraw()');
						},
						onSuccess: function(data, textStatus, jqXHR) {
							console.log('onSuccess(data, textStatus, jqXHR)');
							console.log(data);
							console.log(textStatus);
							console.log(jqXHR);
						},
						onFail: function(jqXHR, textStatus, errorThrown) {
							console.log('onFail(jqXHR, textStatus, errorThrown)');
							console.log(jqXHR);
							console.log(textStatus);
							console.log(errorThrown);
						},
						onAlways: function() {
							console.log('onAlways()');
						},
						onAjax: function(action, serialize) {
							console.log('onAjax(action, serialize)');
							console.log(action);
							console.log(serialize);
						}
					});

			});

			function saveNewPositionsIncome() {
				var positions = [];
				$('.updated').each(function () {
					 positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
					 $(this).removeClass('updated');
				});

				$.ajax({
					 url: 'settings-manage-categories.php',
					 method: 'POST',
					 dataType: 'text',
					 data: {
							 updateIncome: 1,
							 positions: positions
					 }, success: function (response) {
								console.log(response);
					 }
				});
			}

		</script>

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
