<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_gr">
		<div class="ib_dashboard">
			<h1><i class="fa fa-key"></i> Change Password &nbsp;<a href="?tab=users"><span class="ib_dashboard_btn bg_green"><i class="fa fa-arrow-left"></i> Return to users</span></a> &nbsp;<a href="?tab=users&action=view&id=<?php echo $_GET['id']?>"><span class="ib_dashboard_btn bg_green"><i class="fa fa-eye"></i> View</span></a> &nbsp;<a href="?tab=users&action=change_pass&id=<?php echo $_GET['id']?>"><span class="ib_dashboard_btn bg_green"><i class="fa fa-key"></i> Change Password</span></a></h1>
		</div>
		<div class="ib_content">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if (isset($_POST['change_password'])) {
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
			?><br>
			<form class="ib_dashboard_form bg_white" action="" method="POST" enctype="multipart/form-data">
				<label class="ib_dashboard_label" for="oldpass">Old Password</label>
				<input class="ib_dashboard_input" type="password" name="oldpass" placeholder="*Old Password" autocomplete="off" required>
				<label class="ib_dashboard_label" for="newpass1">New Password</label>
				<input class="ib_dashboard_input" type="password" name="newpass1" placeholder="*New Password" autocomplete="off" required>
				<label class="ib_dashboard_label" for="newpass2">Confirm Password</label>
				<input class="ib_dashboard_input" type="password" name="newpass2" placeholder="*Confirm Password"  autocomplete="off" required>
				<br>
				<br>
				<button class="ib_dashboard_button bg_green" name="change_password">Change Password</button>
				<br><br><br>
			</form>
		</div>
	</div>
</article>