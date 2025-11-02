<?php
	require_once 'app/ib_init.php';

	if (IB_Token::checkToken()) {
		if (IB_Role::checkRoleIfAdmin(IB_User::getUserData('RID'))) {
			IB_View::getView('navigation.admin_panel');
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Dashboard &sdot; G-Shock Warriors</title>
		<link rel="stylesheet" type="text/css" href="css/ib_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_user_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_grid_style.min.css">
	</head>
	<body class="bg_lg">
		<div class="ib_wrapper">
			<div class="ib_content">
				<div class="grid">
					<?php
						IB_View::getView('navigation.admin_side_panel');

						if (isset($_GET['tab']) && !empty($_GET['tab']) && $_GET['tab'] == 'transactions') {
							if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'view') {
								IB_View::getView('admin.view_transaction');
							} else {
								IB_View::getView('admin.view_transactions');
							}
						} elseif (isset($_GET['tab']) && !empty($_GET['tab']) && $_GET['tab'] == 'collections') {
							if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'create') {
								IB_View::getView('admin.add_collection');
							} elseif (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit') {
								IB_View::getView('admin.edit_collection');
							} else {
								IB_View::getView('admin.view_collections');
							}
						} elseif (isset($_GET['tab']) && !empty($_GET['tab']) && $_GET['tab'] == 'products') {
							if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'create') {
								IB_View::getView('admin.add_product');
							} elseif (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit') {
								IB_View::getView('admin.edit_product');
							} else {
								IB_View::getView('admin.view_products');
							}
						} elseif (isset($_GET['tab']) && !empty($_GET['tab']) && $_GET['tab'] == 'roles') {
							if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'create') {
								IB_View::getView('admin.add_role');
							} elseif (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit') {
								IB_View::getView('admin.edit_role');
							} else {
								IB_View::getView('admin.view_roles');
							}
						} elseif (isset($_GET['tab']) && !empty($_GET['tab']) && $_GET['tab'] == 'users') {
							if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'create') {
								IB_View::getView('admin.add_user');
							} elseif (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit') {
								IB_View::getView('admin.edit_user');
							} elseif (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'change_pass') {
								IB_View::getView('admin.change_pass_user');
							} elseif (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'view') {
								IB_View::getView('admin.view_user');
							} else {
								IB_View::getView('admin.view_users');
							}
						} else {
							IB_View::getView('admin.admin_dashboard');
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>