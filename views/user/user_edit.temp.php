<?php
	if (isset($_POST['update_user'])) {
		echo '<div style="height: 8px; background-color: transparent;"></div>';
		$id = IB_User::checkUser();
		$username = IB_Database::IB_Escape($_POST['username']);
		$email = IB_Database::IB_Escape($_POST['email']);
		$UPASS = FALSE;
		$EPASS = FALSE;
		if (empty($username) || empty($email)) {
			echo '
				<div class="ib_dashboard_form_error bg_red" id="ib_message">
					<i class="fa fa-times-circle"></i>&nbsp; All fields are required
				</div>
			';
		} else {
			if(IB_User::findIfExists(array('Username', $username))) {
				echo '
					<div class="ib_dashboard_form_error bg_red" id="ib_message">
						<i class="fa fa-times-circle"></i>&nbsp; Username already used!
					</div>
				';
			} else {
				$UPASS = TRUE;
			}
			if(IB_User::findIfExists(array('Email', $email))) {
				echo '<div style="height: 8px; background-color: transparent;"></div>';
				echo '
					<div class="ib_dashboard_form_error bg_red" id="ib_message2">
						<i class="fa fa-times-circle"></i>&nbsp; Email already used!
					</div>
				';
			} else {
				$EPASS = TRUE;
			}
			if ($UPASS === TRUE) {
				IB_Database::IB_Query("UPDATE `" . IB_User::getTable() . "` SET u_name = '{$username}' WHERE u_id = '{$id}'");
				echo '
					<div class="ib_dashboard_form_error bg_green" id="ib_message">
						<i class="fa fa-check-circle"></i>&nbsp; Successfully changed your username!
					</div>
				';
			}
			if ($EPASS === TRUE) {
				IB_Database::IB_Query("UPDATE `" . IB_User::getTable() . "` SET u_email = '{$email}' WHERE u_id = '{$id}'");
				echo '<div style="height: 8px; background-color: transparent;"></div>';
				echo '
					<div class="ib_dashboard_form_error bg_green" id="ib_message2">
						<i class="fa fa-check-circle"></i>&nbsp; Successfully changed your email address!
					</div>
				';
			}
		}
	}

	if (isset($_POST['update_info'])) {
		echo '<div style="height: 8px; background-color: transparent;"></div>';
		$id = IB_User::checkUser();
		$first = IB_Database::IB_Escape($_POST['fname']);
		$middle = IB_Database::IB_Escape($_POST['mname']);
		$last = IB_Database::IB_Escape($_POST['lname']);
		$address = IB_Database::IB_Escape($_POST['address']);
		$contact = IB_Database::IB_Escape($_POST['contact']);
		if (empty($first) || empty($last) || empty($address) || empty($contact)) {
			echo '
				<div class="ib_dashboard_form_error bg_red" id="ib_message">
					<i class="fa fa-times-circle"></i>&nbsp; All fields are required
				</div>
			';
		} else {
			$query = IB_Database::IB_Query("SELECT * FROM " . IB_UserInfo::getTable() . " WHERE ui_contact = '{$contact}' AND ui_uid != '{$id}'");
			if (mysqli_num_rows($query) > 0) {
				echo '
					<div class="ib_dashboard_form_error bg_red" id="ib_message">
						<i class="fa fa-times-circle"></i>&nbsp; Contact number already used!
					</div>
				';
			} else {
				$query = IB_Database::IB_Query("SELECT * FROM " . IB_UserInfo::getTable() . " WHERE ui_uid = '{$id}'");
				if (mysqli_num_rows($query) > 0) {
					if (empty($middle)) {
						IB_Database::IB_Query("UPDATE " . IB_UserInfo::getTable() . " SET `ui_first` = '{$first}', `ui_middle` = NULL, `ui_last` = '{$last}', `ui_address` = '{$address}', `ui_contact` = '{$contact}' WHERE ui_uid = '{$id}'");
					} else {
						IB_Database::IB_Query("UPDATE " . IB_UserInfo::getTable() . " SET `ui_first` = '{$first}', `ui_middle` = '{$middle}', `ui_last` = '{$last}', `ui_address` = '{$address}', `ui_contact` = '{$contact}' WHERE ui_uid = '{$id}'");
					}
					echo '
						<div class="ib_dashboard_form_error bg_green" id="ib_message2">
							<i class="fa fa-check-circle"></i>&nbsp; Successfully updated your personal information!
						</div>
					';
				} else {
					if (empty($middle)) {
						IB_Database::IB_Query("INSERT INTO " . IB_UserInfo::getTable() . " (`ui_uid`, `ui_first`, `ui_middle`, `ui_last`, `ui_address`, `ui_contact`) VALUES ('{$id}', '{$first}', NULL, '{$last}', '{$address}', '{$contact}')");
					} else {
						IB_Database::IB_Query("INSERT INTO " . IB_UserInfo::getTable() . " (`ui_uid`, `ui_first`, `ui_middle`, `ui_last`, `ui_address`, `ui_contact`) VALUES ('{$id}', '{$first}', '{$middle}', '{$last}', '{$address}', '{$contact}')");
					}
					echo '
						<div class="ib_dashboard_form_error bg_green" id="ib_message2">
							<i class="fa fa-check-circle"></i>&nbsp; Successfully updated your personal information!
						</div>
					';
				}
			}
		}
	}

	if (isset($_POST['change_password'])) {
		echo '<div style="height: 8px; background-color: transparent;"></div>';
		$id = IB_User::checkUser();
		$oldpass = IB_Database::IB_Escape($_POST['oldpass']);
		$oldhash = sha1($oldpass);
		$newpass = IB_Database::IB_Escape($_POST['newpass1']);
		$newhash = sha1($newpass);
		$confirmpass = IB_Database::IB_Escape($_POST['newpass2']);
		$conhash = sha1($confirmpass);
		if (empty($oldpass) || empty($newpass) || empty($confirmpass)) {
			echo '
				<div class="ib_dashboard_form_error bg_red" id="ib_message">
					<i class="fa fa-times-circle"></i>&nbsp; All fields are required
				</div>
			';
		} else {
			$currentpass = IB_User::getUserPassword();
			if ($oldhash != $currentpass) {
				echo '
					<div class="ib_dashboard_form_error bg_red" id="ib_message">
						<i class="fa fa-times-circle"></i>&nbsp; Old password does not match!
					</div>
				';
			} else {
				if ($oldhash === $newhash) {
					echo '
						<div class="ib_dashboard_form_error bg_blue" id="ib_message">
							<i class="fa fa-exclamation-triangle"></i>&nbsp; Old password cannot be used as your new password!
						</div>
					';
				} else {
					if ($newhash != $conhash) {
						echo '
							<div class="ib_dashboard_form_error bg_red" id="ib_message">
								<i class="fa fa-times-circle"></i>&nbsp; Password does not match!
							</div>
						';
					} else {
						IB_Database::IB_Query("UPDATE `" . IB_User::getTable() . "` SET u_password = '{$conhash}' WHERE u_id = '{$id}'");
						echo '
							<div class="ib_dashboard_form_error bg_green" id="ib_message">
								<i class="fa fa-check-circle"></i>&nbsp; Successfully changed your password! <a href="/auth/signout.php"><span class="ib_product_alt_cart_btn bg_dark"><i class="fa fa-sign-out"></i> Try your new password? Sign out now!</span></a>
							</div>
						';
					}
				}
			}
		}
	}
?>
<script type="text/javascript">
	/* Remove message div instantly */
	function closeMsg() {
	    document.getElementById("ib_message").style.display = "none";
	}

	/* Remove message div after 3 seconds */
	setTimeout(function(){
		$('#ib_message').slideUp("slow");
	}, 3000);

	/* Remove message div after 3 seconds */
	setTimeout(function(){
		$('#ib_message2').slideUp("slow");
	}, 3000);
</script>
<?php
	IB_View::getView('user.user_avatar_upload');
?>
<div class="ib_wrapper">
	<div class="ib_container">
		<section id="team" style="padding: 50px 0px 20px; text-align: center;">
			<div class="grid">
				<form action="" method="POST" enctype="multipart/form-data">
				<article class="module desktop-4 tablet-12">
					<div class="ib_dev">
						<a id="upload_avatar" href="javascript:void(0)" onclick="openNav()">
							<div class="ib_dev_avatar_btn">
								<i class="fa fa-camera fa-5x"></i>
							</div>
						</a>
						<?php
							$findavatar = 'storage/users/avatar/' . IB_User::getUserData('AV') . '">';
							if (file_exists($findavatar) && !empty(IB_User::getUserData('AV'))) {
								echo '<img class="ib_dev_avatar" src="storage/users/avatar/' . IB_User::getUserData('AV') . '">';
							} elseif (!file_exists($findavatar) && empty(IB_User::getUserData('AV'))) {echo '<img class="ib_dev_avatar" src="storage/users/avatar/default.jpg">';
							} else {
								echo '<img class="ib_dev_avatar" src="storage/users/avatar/default.jpg">';
							}
						?>
					</div>
					<h3 class="ib_dev_name">
						<input class="ib_dev_input" type="text" id="realname" name="username" pattern="^[A-Za-z0-9_.,]{1,32}$" value="<?php echo IB_User::getUserData('UN');?>" autocomplete="off" required>
					</h3>
					<h5 class="ib_dev_sub">*Username</h5>
					<br>
					<h3 class="ib_dev_name">
						<input class="ib_dev_input" type="email" name="email" value="<?php echo IB_User::getUserData('EM');?>" autocomplete="off" required>
					</h3>
					<h5 class="ib_dev_sub">*Email</h5><br>
					<h3 class="ib_dev_sub">
						<button class="ib_dev_btn" style="float: none;" name="update_user" value="1">Save Changes</button>
					</h3>
				</article>
				</form>
				<form action="" method="POST" enctype="multipart/form-data">
				<article class="module desktop-8 tablet-12">
					<div class="grid">
						<article class="module desktop-12 tablet-12" style="margin-bottom: 0;">
							<h1 class="ib_dev_high" style="margin-bottom: 0px;"><i class="fa fa-user"></i> Customer Information <a href="user.php"><span class="ib_dev_high_btn">Return Profile</span></a></h1>
							<p class="ib_dev_high_des"><i class="fa fa-exclamation-circle fa-fw"></i> Save before returning to your profile page</p>
						</article>
						<article class="module desktop-7 tablet-12">
							<div class="ib_featured_label bg_green">
								<span class="ib_featured_new"></span><i class="fa fa-user"></i> Personal Information
							</div>
							<div class="ib_user_information">
								<form class="ib_user_form" action="" method="POST">
									<h3 class="ib_dev_name">
										<input class="ib_dev_input" type="text" name="fname" pattern="^[A-Za-z_. ,]{1,50}$" value="<?php echo IB_UserInfo::getUserInfo('FN');?>" autocomplete="off" required>
									</h3>
									<h5 class="ib_dev_sub">*First Name</h5><br>
									<h3 class="ib_dev_name">
										<input class="ib_dev_input" type="text" name="mname" pattern="^[A-Za-z_.,]{1,30}$" value="<?php echo IB_UserInfo::getUserInfo('MN');?>" autocomplete="off">
									</h3>
									<h5 class="ib_dev_sub">Middle Name</h5><br>
									<h3 class="ib_dev_name">
										<input class="ib_dev_input" type="text" name="lname" pattern="^[A-Za-z_. ,]{1,30}$" value="<?php echo IB_UserInfo::getUserInfo('LN');?>" autocomplete="off" required>
									</h3>
									<h5 class="ib_dev_sub">*Last Name</h5><br>
									<div class="ib_dev_name">
										<input class="ib_dev_input" type="text" name="address" pattern="^[A-Za-z0-9_. ,]{1,255}$" value="<?php echo IB_UserInfo::getUserInfo('AD');?>" autocomplete="off" required>
									</div>
									<h5 class="ib_dev_sub">*Full Address</h5><br>
									<div class="ib_dev_name">
										<input class="ib_dev_input" type="text" name="contact" pattern="^[0-9]{1,11}$" value="<?php echo IB_UserInfo::getUserInfo('CN');?>" autocomplete="off" required>
									</div>
									<h5 class="ib_dev_sub">*Contact Number</h5><br>
									<h3 class="ib_dev_sub">
										<button class="ib_dev_btn" style="float: none;" name="update_info" value="1">Save changes</button>
									</h3>
								</form>
							</div>
						</article>
						<article class="module desktop-5 tablet-12">
							<div class="ib_featured_label bg_green">
								<span class="ib_featured_new"></span><i class="fa fa-key"></i> Change Password
							</div>
							<div class="ib_user_information">
								<form class="ib_user_form" action="" method="POST">
									<h3 class="ib_dev_name">
										<input class="ib_dev_input" type="password" id="realname" name="oldpass" autocomplete="off" required>
									</h3>
									<h5 class="ib_dev_sub">*Old Password</h5><br>
									<h3 class="ib_dev_name">
										<input class="ib_dev_input" type="password" id="realname" name="newpass1" autocomplete="off" required>
									</h3>
									<h5 class="ib_dev_sub">*New Password</h5><br>
									<h3 class="ib_dev_name">
										<input class="ib_dev_input" type="password" id="realname" name="newpass2" autocomplete="off" required>
									</h3>
									<h5 class="ib_dev_sub">*Confirm Password</h5><br>
									<h3 class="ib_dev_sub">
										<button class="ib_dev_btn" style="float: none;" name="change_password" value="1">Change password</button>
									</h3>
								</form>
							</div>
						</article>
					</div>
				</article>
				</form>
			</div>
		</section>
	</div>
</div>