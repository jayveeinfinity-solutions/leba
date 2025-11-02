<?php
	require_once 'app/ib_init.php';

	if (IB_Token::checkToken() === TRUE) {
		header('location: /403');
	}

	if (isset($_GET['r']) && !empty($_GET['r'])) {
		$redirect = $_GET['r'];
		$redirect = str_replace('/_clients/leba-basic/', '', $redirect);
	} else {
		$redirect = '';
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<title>
    	Sign In &sdot; <?php echo IB_Config::get('info/appname');?>
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
					if (isset($_POST['signin'])) {
						$username = IB_Database::IB_Escape($_POST['username']);
						$_username .= $username;
						$password = IB_Database::IB_Escape($_POST['password']);
						$lockpass = sha1($password);
						$redirect = IB_Database::IB_Escape($_POST['redirect']);
						echo $redirect;
						if (empty($username) || empty($password)) {
							$usererror .= '
								<div class="auth_status">
									<span class="auth_error"><i class="fa fa-exclamation-circle"></i> Fill up all fields</span>
								</div>
							';
						} else {
							$userQ = IB_Database::IB_Query("SELECT u_id, u_name, u_password FROM users_tbl WHERE u_name = '{$username}'");
							if (mysqli_num_rows($userQ) === 0) {
								$usererror .= '
									<div class="auth_status">
										<span class="auth_error"><i class="fa fa-times-circle"></i> Username not signed up!</span>
									</div>
								';
							} else {
								$userF = mysqli_fetch_array($userQ, MYSQLI_BOTH);
								if ($userF['u_password'] != $lockpass) {
									$usererror .= '
										<div class="auth_status">
											<span class="auth_error"><i class="fa fa-times-circle"></i> Password doesn\'t match!</span>
										</div>
									';
								} else {
									$authID = $userF['u_id'];
									IB_Token::setToken($authID);
									header('location: ' . IB_Config::get('info/appurl') . $redirect);
								}
							}
						}
					}
				?>
				<form class="ib_auth bg_white" action="?" method="POST">
					<h2><i class="fa fa-sign-in"></i> Sign In</h2>
					<label>Username</label>
					<input type="hidden" name="redirect" value="<?php echo $redirect;?>">
					<input class="ib_input" type="text" name="username" placeholder="*Username" autocomplete="off" value="<?php echo $_username;?>">
					<label>Password</label>
					<input class="ib_input" type="password" name="password" placeholder="*Password" autocomplete="off">
					<input type="hidden" name="token" value="<?php echo IB_Token::generateToken();?>">
					<!-- <a href="/403"><span class="ib_span">Lost Password <i class="fa fa-question-circle-o"></i> </span></a> -->
					<br>
					<button class="ib_btn" name="signin">
						Sign In
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