<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_gr">
		<div class="ib_dashboard">
			<h1><i class="fa fa-pencil"></i> Edit User &nbsp;<a href="?tab=users"><span class="ib_dashboard_btn bg_green"><i class="fa fa-arrow-left"></i> Return to users</span></a> &nbsp;<a href="?tab=users&action=view&id=<?php echo $_GET['id']?>"><span class="ib_dashboard_btn bg_green"><i class="fa fa-eye"></i> View</span></a> &nbsp;<a href="?tab=users&action=change_pass&id=<?php echo $_GET['id']?>"><span class="ib_dashboard_btn bg_green"><i class="fa fa-key"></i> Change Password</span></a></h1>
		</div>
		<div class="ib_content">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);

				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message2').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if (isset($_POST['update_user'])) {
					$id = $_GET['id'];
					$username = IB_Database::IB_Escape($_POST['username']);
					$email = IB_Database::IB_Escape($_POST['email']);
					$role = IB_Database::IB_Escape($_POST['role']);
					$UPASS = FALSE;
					$EPASS = FALSE;
					if (empty($username) || empty($email) || empty($role)) {
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
						IB_Database::IB_Query("UPDATE `" . IB_User::getTable() . "` SET u_rid = '{$role}' WHERE u_id = '{$id}'");
						echo '<div style="height: 8px; background-color: transparent;"></div>';
						echo '
							<div class="ib_dashboard_form_error bg_green" id="ib_message3">
								<i class="fa fa-check-circle"></i>&nbsp; Successfully changed your role!
							</div>
						';
					}
				}
			?><br>
			<form class="ib_dashboard_form bg_white" action="" method="POST" enctype="multipart/form-data">
				<label class="ib_dashboard_label" for="username">Username</label>
				<input class="ib_dashboard_input" type="text" name="username" placeholder="*Username" value="<?php echo IB_User::getUserData('UN', $_GET['id']);?>" autocomplete="off" required>
				<label class="ib_dashboard_label" for="email">Email</label>
				<input class="ib_dashboard_input" type="email" name="email" placeholder="*Email" value="<?php echo IB_User::getUserData('EM', $_GET['id']);?>" autocomplete="off" required>
				<label class="ib_dashboard_label" for="role">Role</label>
				<select class="ib_dashboard_input" name="role" required>
					<?php
						if(IB_Role::getRoles()) {
							$data = IB_Role::getRoles('ORDER BY r_label');
							$i = 0;
							while ($i <= count($data) - 1) {
								if (IB_Role::findRole($_GET['id'])[0][0] ==  $data[$i][0]) {
									echo '<option value="' . $data[$i][0] . '" selected>' . $data[$i][1] . '</option>';
								} else {
									echo '<option value="' . $data[$i][0] . '">' . $data[$i][1] . '</option>';
								}
								$i++;
							}
						}
					?>
				</select>
				<br>
				<br>
				<button class="ib_dashboard_button bg_green" name="update_user">Save</button>
				<br><br><br>
			</form>
		</div>
	</div>
</article>