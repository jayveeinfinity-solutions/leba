<div class="ib_wrapper bg_darker">
	<div class="ib_content">
		<section class="ib_header">
			<a href="./"><div class="ib_webname"><?php echo IB_Config::get('info/appname') ?></div></a>
			<form class="ib_header_form" action="store.php" method="GET">
				<input class="ib_header_input typeahead" type="text" name="search" id="lebasearch" placeholder="Quick search">
				<!-- <button class="ib_header_button bg_green" name="goto">Search</button> -->
			</form>
			<div class="ib_header_auth">
				<ul>
					<?php
						if (IB_Token::checkToken()) {
							if (IB_Role::checkRoleIfAdmin(IB_User::getUserData('RID'))) {
								echo '
									<a href="javascript:void(0)"><li class="ib_header_auth_user"><i class="fa fa-user' . (IB_Role::checkRoleIfAdmin(IB_User::getUserData('RID')) ? '-secret' : ''). '"></i>&nbsp; Welcome, ' . ucfirst(IB_User::getUserData('UN')) . '!</li></a>
									<a href="./signout.php"><li>Sign Out</li></a>
								';
							} else {
								echo '
									<a href="./user.php"><li class="ib_header_auth_user"><i class="fa fa-user' . (IB_Role::checkRoleIfAdmin(IB_User::getUserData('RID')) ? '-secret' : ''). '"></i>&nbsp; Welcome, ' . ucfirst(IB_User::getUserData('UN')) . '!</li></a>
									<a href="./signout.php"><li>Sign Out</li></a>
								';
							}
						} else {
							echo '
								<li class="ib_header_auth_user"><i class="fa fa-user"></i>&nbsp; Welcome, Guest!</li>
								<a href="./signin.php"><li>Sign In</li></a>
								<a href="./signup.php"><li>Sign Up</li></a>
							';
						}
					?>
				</ul>
			</div>
		</section>
	</div>
</div>
<script type="text/javascript" src="app/helpers/jquery-2.1.4.js"></script>
<script type="text/javascript" src="app/helpers/typeahead.min.js"></script>
<script type="text/javascript">
	// ==============================Quick Search================================= //
	$(document).ready(function() {
		$('#lebasearch').typeahead( {
		    name: 'lebasearch',
			minLength: 1,
		    limit : 25,
			remote: {
	            url : 'app/helpers/search.php?key=%QUERY'
	        }
		});
	});
</script>