<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_lg">
		<div class="ib_dashboard">
			<h1><i class="fa fa-users"></i>&nbsp; Users &nbsp;<a href="?tab=users&action=create"><span class="ib_dashboard_btn bg_green"><i class="fa fa-user-plus"></i> &nbsp;Add user</span></a></h1>
		</div>
		<div class="ib_content" style="padding: 0px 30px;">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] === 'delete') {
					if(isset($_GET['id']) && !empty($_GET['id']) && in_array($_GET['id'], IB_User::getAllUsersID())) {
						$query = IB_Database::IB_Query("SELECT * FROM " . IB_User::getTable() . " WHERE u_id = '{$_GET['id']}' AND u_rid = 1");
						if (mysqli_num_rows($query) > 0) {
							echo '
								<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; User cannot be deleted!</div>
							';
						} else {
							IB_Database::IB_Query("DELETE FROM `" . IB_User::getTable() . "` WHERE u_id = '{$_GET['id']}'");
							echo '
								<div class="ib_dashboard_form_error bg_green" id="ib_message"><i class="fa fa-check-circle"></i>&nbsp; Successfully deleted a user!</div>
							';
						}
					}
				}
				echo "<br>";
				IB_User::viewTable();
			?>
		</div>
	</div>
</article>