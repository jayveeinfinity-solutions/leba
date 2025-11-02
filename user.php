<?php
	require_once 'app/ib_init.php';

	if (!IB_Token::checkToken()) {
		header('location: /403');
	}
?>	
<!DOCTYPE html>
<html>
	<head>
		<title>My Account &sdot; G-Shock Warriors</title>
		<link rel="stylesheet" type="text/css" href="css/ib_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_user_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_grid_style.min.css">
	</head>
	<body class="bg_lg">
		<?php
			IB_View::getView('navigation.header');
		?>
		<div class="ib_wrapper">
			<div class="ib_content">
				<section class="ib_body">
					<div class="grid">
						<?php
							IB_View::getView('navigation.user_panel_user');
						?>
						<article class="module desktop-12 tablet-12">
						<?php
							if (isset($_GET['tab']) && !empty($_GET['tab']) && $_GET['tab'] == 'edit') {
								IB_View::getView('user.user_edit');
							} else {
								IB_View::getView('user.user_view');
							}
						?>
						</article>
					</div>
				</section>
			</div>
		</div>
	</body>
</html>