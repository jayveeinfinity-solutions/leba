<?php
	require_once 'app/ib_init.php';

	if (IB_Token::checkToken() === TRUE) {
		header('location: /403');
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<title>
    	Sign Up &sdot; <?php echo IB_Config::get('info/appname');?>
	</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="x icon" type="img/png" href="storage/img/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/ib_style.min.css">
	<link rel="stylesheet" type="text/css" href="css/ib_auth_style.min.css">
	<link rel="stylesheet" type="text/css" href="css/ib_responsive_nav.min.css">
	<link rel="stylesheet" type="text/css" href="css/ib_grid_style.min.css">
	</head>
	<body class="bg_darker">
		<?php
			IB_View::getView('navigation.header');
		?>
		<div class="ib_wrapper bg_lg">
			<div class="ib_auth_main">
				<?php
					$usererror = '';
					$_username = '';
					$_email = '';
					if (isset($_POST['signup'])) {
						$username = IB_Database::IB_Escape($_POST['username']);
						$_username .= $username;
						$password = IB_Database::IB_Escape($_POST['password']);;
						$password2 = IB_Database::IB_Escape($_POST['password2']);;
						$hash = sha1($password);
						$hash2 = sha1($password2);
						$email = IB_Database::IB_Escape($_POST['email']);
						$_email .= $email;
						if (empty($username) || empty($password) || empty($email)) {
							$usererror .= '
								<div class="auth_status">
									<span class="auth_error"><i class="fa fa-exclamation-circle"></i> Fill up all fields</span>
								</div>
							';
						} else {
							$userQ = IB_Database::IB_Query("SELECT u_name FROM users_tbl WHERE u_name = '{$username}'");
							if (mysqli_num_rows($userQ) === 1) {
								$_username = '';
								$usererror .= '
									<div class="auth_status">
										<span class="auth_error"><i class="fa fa-times-circle"></i> Username already used!</span>
									</div>
								';
							} else {
								$emailQ = IB_Database::IB_Query("SELECT u_name FROM users_tbl WHERE u_email = '{$email}'");
								if (mysqli_num_rows($emailQ) === 1) {
									$_email = '';
									$usererror .= '
										<div class="auth_status">
											<span class="auth_error"><i class="fa fa-times-circle"></i> Email already used!</span>
										</div>
									';
								} else {
									if ($hash != $hash2) {
										$usererror .= '
											<div class="auth_status">
												<span class="auth_error"><i class="fa fa-times-circle"></i> Passwords does not match!</span>
											</div>
										';
									} else {
										IB_Database::IB_Query("INSERT INTO `users_tbl` (`u_name`,`u_email`,`u_password`) VALUES ('{$username}', '{$email}', '{$hash}')");
										$_username = '';
										$_email = '';
										$usererror .= '
											<div class="auth_status">
												<span class="auth_success"><i class="fa fa-check-circle"></i> Successfully created an account!</span>
											</div>
										';
									}
								}
							}
						}
					}
				?>
				<form class="ib_auth bg_white" action="?" method="POST">
					<h2><i class="fa fa-sign-in"></i> Sign Up</h2>
					<label>Username</label>
					<input class="ib_input" type="text" name="username" placeholder="*Username" autocomplete="off" value="<?php echo $_username;?>" required>
					<label>Password</label>
					<input class="ib_input" type="password" name="password" placeholder="*Password" autocomplete="off" required>
					<label>Retype Password</label>
					<input class="ib_input" type="password" name="password2" placeholder="*Password" autocomplete="off" required>
					<label>Retype Password</label>
					<input class="ib_input" type="email" name="email" placeholder="*example@site.domain" autocomplete="off" value="<?php echo $_email;?>">
					<input type="hidden" name="token" value="<?php echo IB_Token::generateToken();?>" required>
					<!-- <a href="/403"><span class="ib_span">Lost Password <i class="fa fa-question-circle-o"></i> </span></a> -->
					<br>
					<button class="ib_btn" name="signup">
						Sign Up
					</button>
					<?php
						echo $usererror;
					?>
				</form>
			</div>
		</div>
		<!-- <?php
			include_once 'templates/ib_footer.temp.php';
		?> -->
	</body>
</html>