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

	//GET BUSINESS NAME
	$sql = "SELECT * FROM business
					WHERE businessID=$businessID";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$businessName = $data['businessName'];
	}

	//GET EXISTING COVER IMAGE FILE NAME
	$sql = "SELECT * FROM businessVenueManagement
					WHERE businessID=$businessID";
	$result = mysqli_query($con,$sql);
	while ($data = $result->fetch_assoc()){
		$businessVenueManagementID = $data['businessVenueManagementID'];
		$coverImageFileName = $data['coverImageFileName'];
	}

	//COVER IMAGE UPLOAD
	if(isset($_POST["uploadCover"])){
		$targetDir = "./uploads/businessCoverImage/";
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
						"UPDATE
							businessVenueManagement
						SET
							coverImageFileName = '$targetFilePath'
						WHERE
							businessVenueManagementID = '$businessVenueManagementID'
							AND
							businessID = '$businessID'
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

	//PHOTO GALLERY UPLOAD
	if(isset($_POST["upload"])){
		$imageDescription = $_POST['imageDescription'];
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
		<link href="css/owl.carousel.min.css" rel="stylesheet">
		<link href="css/owl.theme.default.min.css" rel="stylesheet">
		<style type="text/css">
			/* FOR IMG */
			img {
			  transition: 0.8s;
				border-radius: 3;
			}
			/* img:hover {
				transform: rotate(360deg);
			} */

			/* FOR IMAGE CAROUSEL */

			* {box-sizing: border-box}

			/* Container needed to position the overlay. Adjust the width as needed */
			.container {
			  position: relative;
				width: auto;
			}

			/* Make the image to responsive */
			.image {
			  display: block;
			  width: 100%;
			  height: auto;
			}

			/* The overlay effect - lays on top of the container and over the image */
			.overlay {
			  position: absolute;
			  bottom: 0;
			  background: rgb(0, 0, 0);
			  background: rgba(0, 0, 0, 0.5); /* Black see-through */
			  color: #f1f1f1;
			  width: 96.4%;
			  transition: .5s ease;
			  opacity:0;
			  color: white;
			  font-size: 15px;
			  padding: 15px;
			  text-align: center;
			}

			/* When you mouse over the container, fade in the overlay title */
			.container:hover .overlay {
			  opacity: 1;
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

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="business-dashboard.php">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Venue Management -> Gallery</li>
				</ol>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Gallery</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-orange">
						<div class="panel-heading"><center>COVER IMAGE</center></div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<h3><b>UPLOAD</b><br>New Cover Image</h3><br>
							<form method="post" action="" enctype="multipart/form-data">
								<center>
									<div class="form-group">
										<label><span class="fa fa-file"></span>&nbsp Image File<br>(Accepted File Format: png, jpg, jpeg)</label><br>
										<input type="file" name="file">
									</div><br>
									<div style="text-align: center;" class="form-group has-success">
										<button type="submit" name="uploadCover" class="btn bg-orange" ><i class="fa fa-upload fa-lg"></i><b>&nbsp UPLOAD IMAGE</b></button>
									</div><br>
								</center>
							</form>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body easypiechart-panel">
							<?php if ($coverImageFileName): ?>
								<h3><b>EXISTING</b><br>Cover Image</h3><br>
								<img src="<?php echo $coverImageFileName ?>" width="100%" height="450"><br><br>
								<center>
									<a href="<?php echo $coverImageFileName; ?>" target="_blank" class="btn bg-orange"><b><i class="fa fa-search fa-lg"></i>&nbsp VIEW</b></a>
									&nbsp
									<a href="business-venueManagement-gallery-deleteCoverImage.php?businessVenueManagementID=<?php echo $businessVenueManagementID ?>" onclick="return confirm('Are you sure to delete this image? This action cannot be reverted!')" class="btn bg-red"><b><i class="fa fa-trash fa-lg"></i>&nbsp DELETE</b></a>
								</center>
								<br>
							<?php else: ?>
								<br><center><img src="images/icon-noImageAvailable.png" width="25%" height="25%"></center><br>
							<?php endif; ?>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-teal">
						<div class="panel-heading"><center>PHOTO GALLERY</center></div>
					</div>
				</div>
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
										<button type="submit" name="upload" class="btn bg-teal" ><i class="fa fa-upload fa-lg"></i><b>&nbsp UPLOAD IMAGE</b></button>
									</div><br>
								</center>
							</form>
						</div><!-- /.panel-body-->
					</div><!-- /.panel-->
				</div><!-- /.col-->
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>VIEW / DELETE</b><br>Existing Images</h3>
								<div class="col-md-12"><br>
									<table id="imageFiles_table" class="table table-stripped table-hover table-bordered">
										<thead>
											<tr>
												<th id="FileName" style="width:5%;"><span class="fa fa-file"></span>&nbsp File Path Name</th>
												<th id="Format" style="width:5%;"><span class="fa fa-file-image-o"></span>&nbsp File Format</th>
												<th id="Description" style="width:5%;"><span class="fa fa-sticky-note-o"></span>&nbsp Description</th>
												<th id="DateUploaded" style="width:5%;"><span class="fa fa-upload"></span>&nbsp Uploaded On</th>
												<th id="View" style="width:5%;">VIEW</th>
												<th id="Delete" style="width:5%;">DELETE</th>
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
												<tr>
													<td style="display: none;"><?php echo $identifiers;?></td>
													<th id="FileName" style="width:5%;"><?php echo $imageFileName ?></th>
													<td id="Format" style="width:5%;"><?php echo $imageFileType ?></td>
													<td id="Description" style="width:5%;"><?php echo $imageDescription ?></td>
													<td id="DateUploaded" style="width:5%;"><?php echo $imageFileUploadTimeStamp ?></td>
													<td id="View">
														<a href="<?php echo $imageFileName; ?>" target="_blank" class="btn bg-teal"><i class="fa fa-search fa-lg"></i></a>
													</td>
													<td id="Delete" style="width:5%;">
														<a href="business-venueManagement-gallery-deleteGalleryImage.php?businessVenueImageID=<?php echo $businessVenueImageID; ?>" onclick="return confirm('Are you sure to delete this image? This action cannot be reverted!')" class="btn btn-danger"><i class="fa fa-trash fa-lg"></i></a>
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
			</div><!-- /.row -->

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 align="center"><b>GALLERY</b></h3><br>
								<?php
								//OBTAIN IMAGE FILE PATH
								$sql = "SELECT * FROM businessVenueGallery
												WHERE businessID=$businessID";
								$result = mysqli_query($con,$sql);

								if (mysqli_num_rows($result) == 0) {
								?>
									<center><img src="images/icon-noImageAvailable.png" width="25%" height="25%"></center><br>
								<?php
								}
								else {
								?>
									<div class="owl-carousel owl-theme">
								<?php
								while ($data = $result->fetch_assoc()){
									$imageFileName = $data['imageFileName'];
									$imageDescription = $data['imageDescription'];
									//DISPLAY IMAGE CAROUSEL
								?>
									<div class="container">
										<div class="item" data-merge="3"><img src="<?php echo $imageFileName ?>" width="100%" height="450"></div>
										<div class="overlay">
											<div class="text"><?php echo $imageDescription ?></div>
										</div>
									</div>
								<?php
								}
							}
								?>
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

		<script src="js/jquery-3.6.0.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.owl-carousel').owlCarousel({
					items:1,
					loop:true,
					margin:10,
					center:true,
					autoWidth:true,
					autoHeight:true,
					nav:true,
					autoplay:true,
					autoplayTimeout:5000,
					autoplayHoverPause:true
				})
			});
		</script>

		<!--javascript source-->
		<!-- <script src="js/jquery-1.11.1.min.js"></script> -->
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
