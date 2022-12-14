<?php
	session_start();
	error_reporting(0);
	include('includes/dbconnection.php');
?>

	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">
            <div class="profile-userpic">
                <img src="images/businessAvatar.png" class="img-responsive">
            </div>
            <div class="profile-usertitle">
              <?php
	              $uid=$_SESSION['ASportBusinessSessionCounter'];
	              $ret=mysqli_query($con,"select businessName from business where businessID='$uid'");
	              $row=mysqli_fetch_array($ret);
	              $name=$row['businessName'];
              ?>
              <div class="profile-usertitle-name"><?php echo $name; ?></div>
              <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
							<div class="profile-logout"><a href="" onclick="logoutConfirmation()"><i class="fa fa-power-off fa-lg" aria-hidden="true"></i></a></div>
							<script>
								function logoutConfirmation() {
									if (confirm("Are you sure to logout?") == true) {
										location.href = "business-logout.php";
										location.href = "business-login.php";
									}
								}
							</script>
            </div>
            <div class="clear"></div>
        </div>

        <div class="divider"></div>

        <ul class="nav menu">
          <li
						<?php
							if (PAGE == 'Dashboard') {
								echo "class='active'";
							}
						?>
					>
						<a href="business-dashboard.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a>
					</li>

					<li
						<?php
							if (PAGE == 'Analytics') {
								echo "class='active'";
							}
						?>
					>
						<a href="business-analytics.php"><em class="fa fa-lightbulb-o">&nbsp;</em>&nbsp Analytics</a>
					</li>

					<li
						<?php
							if (PAGE == 'Entrance Verification') {
								echo "class='active'";
							}
						?>
					>
						<a href="business-entranceVerification.php"><em class="fa fa-qrcode">&nbsp;</em>&nbsp Entrance Verification</a>
					</li>

					<li class="parent ">
						<a data-toggle="collapse" href="#sub-item-1">
							<em class="fa fa-ticket">&nbsp;</em> Bookings Management<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
						</a>
						<ul
							<?php
							if (PAGE == "Upcoming" || PAGE == "Past" || PAGE == "Cancelled") {
								echo "class='children collapse in'";
							}
							else {
								echo "class='children collapse'";
							}
							?>
							id="sub-item-1"
						>
							<li>
								<a
									<?php
										if (PAGE == 'Upcoming') {
											echo "class='active'";
										}
									?>
									href="business-bookingsManagement-upcoming.php"><span class="fa fa-calendar-o">&nbsp;</span> Upcoming
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Past') {
											echo "class='active'";
										}
									?>
									href="business-bookingsManagement-past.php"><span class="fa fa-calendar-check-o">&nbsp;</span> Past
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Cancelled') {
											echo "class='active'";
										}
									?>
									href="business-bookingsManagement-cancelled.php"><span class="fa fa-times">&nbsp;</span> Cancelled
								</a>
							</li>
							<li>
						</ul>
					</li><!--parent-->

					<li class="parent ">
						<a data-toggle="collapse" href="#sub-item-2">
							<em class="fa fa-location-arrow">&nbsp;</em> Facility Management<span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
						</a>
						<ul
							<?php
							if (PAGE == "Add New Facility" || PAGE == "My Facilities") {
								echo "class='children collapse in'";
							}
							else {
								echo "class='children collapse'";
							}
							?>
							id="sub-item-2"
						>
							<li>
								<a
									<?php
										if (PAGE == 'Add New Facility') {
											echo "class='active'";
										}
									?>
									href="business-facilityManagement-addNewFacility.php"><span class="fa fa-plus">&nbsp;</span> Add New Facility
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'My Facilities') {
											echo "class='active'";
										}
									?>
									href="business-facilityManagement-myFacilities1.php"><span class="fa fa-hand-o-right">&nbsp;</span> My Facilities
								</a>
							</li>
						</ul>
					</li><!--parent-->

					<li class="parent">
						<a data-toggle="collapse" href="#sub-item-3">
							<em class="fa fa-building-o">&nbsp;</em> Venue Management<span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
						</a>
						<ul
							<?php
							if (PAGE == "About Us" || PAGE == "Contact Us" || PAGE == "Location"|| PAGE == "Gallery") {
								echo "class='children collapse in'";
							}
							else {
								echo "class='children collapse'";
							}
							?>
							id="sub-item-3"
						>
							<li>
								<a
									<?php
										if (PAGE == 'About Us') {
											echo "class='active'";
										}
									?>
									href="business-venueManagement-aboutUs.php"> <span class="fa fa-info-circle">&nbsp;</span> About Us
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Contact Us') {
											echo "class='active'";
										}
									?>
									href="business-venueManagement-contactUs.php"> <span class="fa fa-phone">&nbsp;</span> Contact Us
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Location') {
											echo "class='active'";
										}
									?>
									href="business-venueManagement-location.php"> <span class="fa fa-map">&nbsp;</span> Location
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Gallery') {
											echo "class='active'";
										}
									?>
									href="business-venueManagement-gallery.php"> <span class="fa fa-photo">&nbsp;</span> Gallery
								</a>
							</li>
						</ul>
					</li><!--parent-->

					<li class="parent">
						<a data-toggle="collapse" href="#sub-item-4">
							<em class="fa fa-gear">&nbsp;</em> Settings<span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
						</a>
						<ul
							<?php
							if (PAGE == "Profile Maintenance" || PAGE == "Change Password") {
								echo "class='children collapse in'";
							}
							else {
								echo "class='children collapse'";
							}
							?>
							id="sub-item-4"
						>
							<li>
								<a
									<?php
										if (PAGE == 'Profile Maintenance') {
											echo "class='active'";
										}
									?>
									href="business-settings-profileMaintenance.php"><span class="fa fa-user">&nbsp;</span> Profile Maintenance
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Change Password') {
											echo "class='active'";
										}
									?>
									href="business-settings-changePassword.php"><span class="fa fa-key">&nbsp;</span> Change Password
								</a>
							</li>
						</ul>
					</li><!--parent-->

        </ul><!--nav menu-->


    </div><!--sidebar-collapse-->
