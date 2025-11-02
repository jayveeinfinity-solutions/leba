<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_gr">
		<div class="ib_dashboard">
			<h1><i class="fa fa-user-plus"></i> Add User &nbsp;<a href="?tab=users"><span class="ib_dashboard_btn bg_green"><i class="fa fa-arrow-left"></i> Return to users</span></a></h1>
		</div>
		<div class="ib_content">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if (isset($_POST['submit_user'])) {
					$errors = array();
					$username = IB_Database::IB_Escape($_POST['username']);
					$password = IB_Database::IB_Escape($_POST['password']);
					$hash = sha1($password);
					$password2 = IB_Database::IB_Escape($_POST['password2']);
					$hash2 = sha1($password2);
					$email = IB_Database::IB_Escape($_POST['email']);
					$roleid = IB_Database::IB_Escape($_POST['role']);
					if (empty($username) || empty($password) || empty($password2) || empty($email) || empty($roleid)) {
						$errors[] = '
							<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; All fields are required!</div>
						';
					} else {
						$query = IB_Database::IB_Query("SELECT * FROM " . IB_User::getTable() . " WHERE u_name = '{$username}'");
						if (mysqli_num_rows($query) > 0) {
							$errors[] = '
								<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; Username is already exists!</div>
							';
						} else {
							$query = IB_Database::IB_Query("SELECT * FROM " . IB_User::getTable() . " WHERE u_email = '{$email}'");
							if (mysqli_num_rows($query) > 0) {
								$errors[] = '
									<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; Email is already used!</div>
								';
							} else {
								if ($hash != $hash2) {
									$errors[] = '
										<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; Passwords not match!</div>
									';
								} else {
									IB_Database::IB_Query("INSERT INTO `" . IB_User::getTable() . "` (`u_rid`, `u_name`, `u_email`, `u_password`) VALUES ('{$roleid}', '{$username}', '{$email}', '{$hash}')");
									$errors[] = '
										<div class="ib_dashboard_form_error bg_green" id="ib_message"><i class="fa fa-check-circle"></i>&nbsp; New user successfully created!</div>
									';
								}
							}
						}
					}
					echo '<div id="ib_message">';
					foreach ($errors as $key => $value) {
						echo $value;
					}
					echo '</div>';
				}
			?><br>
			<form class="ib_dashboard_form bg_white" action="" method="POST" enctype="multipart/form-data">
				<label class="ib_dashboard_label" for="username">Username</label>
				<input class="ib_dashboard_input" type="text" name="username" placeholder="*Username" autocomplete="off" required>
				<label class="ib_dashboard_label" for="email">Email</label>
				<input class="ib_dashboard_input" type="email" name="email" placeholder="*Email" autocomplete="off" required>
				<label class="ib_dashboard_label" for="password">Password</label>
				<input class="ib_dashboard_input" type="password" name="password" placeholder="*Password" autocomplete="off" required>
				<label class="ib_dashboard_label" for="password2">Confirm Password</label>
				<input class="ib_dashboard_input" type="password" name="password2" placeholder="*Confirm Password" autocomplete="off" required>
				<label class="ib_dashboard_label" for="role">Role</label>
				<select class="ib_dashboard_input" name="role" required>
					<?php
						if(IB_Role::getRoles()) {
							$data = IB_Role::getRoles('ORDER BY r_label');
							$i = 0;
							while ($i <= count($data) - 1) {
								echo '<option value="' . $data[$i][0] . '">' . $data[$i][1] . '</option>';
								$i++;
							}
						}
					?>
				</select>
				<br>
				<br>
				<button class="ib_dashboard_button bg_green" name="submit_user">Save</button>
				<br><br><br>
			</form>
		</div>
	</div>
</article>