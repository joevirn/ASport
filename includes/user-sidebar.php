<?php
	session_start();
	error_reporting(0);
	include('includes/dbconnection.php');
?>

	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">
            <div class="profile-userpic">
                <img src="images/userAvatar.png" class="img-responsive">
            </div>
            <div class="profile-usertitle">
              <?php
	              $uid=$_SESSION['ASportUserSessionCounter'];
	              $ret=mysqli_query($con,"select userName from users where userID='$uid'");
	              $row=mysqli_fetch_array($ret);
	              $name=$row['userName'];
              ?>
              <div class="profile-usertitle-name"><?php echo $name; ?></div>
              <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
							<div class="profile-logout"><a href="" onclick="logoutConfirmation()"><i class="fa fa-power-off fa-lg" aria-hidden="true"></i></a></div>
							<script>
								function logoutConfirmation() {
									if (confirm("Are you sure to logout?") == true) {
										location.href = "user-logout.php";
										location.href = "user-login.php";
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
						<a href="user-dashboard.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a>
					</li>

					<li
						<?php
							if (PAGE == 'New Booking') {
								echo "class='active'";
							}
						?>
					>
						<a href="user-bookings-new1.php"><em class="fa fa-calendar-plus-o">&nbsp;</em> New Booking</a>
					</li>

					<li class="parent ">
						<a data-toggle="collapse" href="#sub-item-1">
							<em class="fa fa-calendar">&nbsp;</em> My Bookings<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
						</a>
						<ul
							<?php
							if (PAGE == "Upcoming" || PAGE == "Past") {
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
									href="user-bookings-upcoming.php"><span class="fa fa-calendar-o">&nbsp;</span> Upcoming
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Past') {
											echo "class='active'";
										}
									?>
									href="user-bookings-past.php"><span class="fa fa-calendar-check-o">&nbsp;</span> Past
								</a>
							</li>
						</ul>
					</li><!--parent-->

					<li class="parent ">
						<a data-toggle="collapse" href="#sub-item-2">
							<em class="fa fa-money">&nbsp;</em> Loyalty<span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
						</a>
						<ul
							<?php
							if (PAGE == "Points" || PAGE == "Rewards" || PAGE == "Rewards Catalogue") {
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
										if (PAGE == 'Points') {
											echo "class='active'";
										}
									?>
									href="user-loyalty-points.php"><span class="fa fa-google-wallet">&nbsp;</span> Points
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Rewards') {
											echo "class='active'";
										}
									?>
									href="user-loyalty-rewards.php"><span class="fa fa-gift">&nbsp;</span> Rewards
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Rewards Catalogue') {
											echo "class='active'";
										}
									?>
									href="user-loyalty-rewardsCatalogue.php"><span class="fa fa-th-large">&nbsp;</span> Rewards Catalogue
								</a>
							</li>
						</ul>
					</li><!--parent-->

					<li class="parent">
						<a data-toggle="collapse" href="#sub-item-4">
							<em class="fa fa-question-circle">&nbsp;</em> Help Centre<span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
						</a>
						<ul
							<?php
							if (PAGE == "Frequently Asked Questions" || PAGE == "Terms and Conditions" || PAGE == "Contact Us") {
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
										if (PAGE == 'Frequently Asked Questions') {
											echo "class='active'";
										}
									?>
									href="user-helpCentre-faq.php"> <span class="fa fa-question">&nbsp;</span> Frequently Asked Questions
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Terms and Conditions') {
											echo "class='active'";
										}
									?>
									href="user-helpCentre-tnc.php"> <span class="fa fa-list-alt">&nbsp;</span> Terms and Conditions
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Contact Us') {
											echo "class='active'";
										}
									?>
									href="user-helpCentre-contactUs.php"> <span class="fa fa-phone">&nbsp;</span> Contact Us
								</a>
							</li>
						</ul>
					</li><!--parent-->

					<li class="parent">
						<a data-toggle="collapse" href="#sub-item-5">
							<em class="fa fa-gear">&nbsp;</em> Settings<span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="fa fa-plus"></em></span>
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
							id="sub-item-5"
						>
							<li>
								<a
									<?php
										if (PAGE == 'Profile Maintenance') {
											echo "class='active'";
										}
									?>
									href="user-settings-profileMaintenance.php"><span class="fa fa-user">&nbsp;</span> Profile Maintenance
								</a>
							</li>
							<li>
								<a
									<?php
										if (PAGE == 'Change Password') {
											echo "class='active'";
										}
									?>
									href="user-settings-changePassword.php"><span class="fa fa-key">&nbsp;</span> Change Password
								</a>
							</li>
						</ul>
					</li><!--parent-->

        </ul><!--nav menu-->


    </div><!--sidebar-collapse-->
