<div class="ib_wrapper bg_green">
	<div class="ib_content">
		<section class="ib_admin_nav">
			<a href="./dashboard.php"><div class="ib_admin_nav_name"><?php echo IB_Config::get('info/appname');?> <span class="ib_admin_nav_sub">Dashboard</span></div></a>
			<div class="ib_header_auth" style="margin-right: 12px;">
				<?php
					if (IB_Token::checkToken()) {
						echo '
							<a href="./signout.php"><div class="ib_admin_nav_link">Sign out</div></a>
						';
					}
				?>
			</div>
		</section>
	</div>
</div>