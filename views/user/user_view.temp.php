<?php
	$msgs = array('1', '2', '3');
	if (isset($_GET['am']) && !empty($_GET['am']) && in_array($_GET['am'], $msgs)) {
		echo '<div style="height: 8px; background-color: transparent;"></div>';
		switch ($_GET['am']) {
			case 1:
				echo '
					<div class="ib_dashboard_form_error bg_blue" id="ib_message">
						<i class="fa fa-exclamation-triangle"></i>&nbsp; Avatar must have maximum file size of 2 MB and file type of GIF, JPG, and PNG image format
					</div>
				';
				break;
			case 2:
				echo '
					<div class="ib_dashboard_form_error bg_red" id="ib_message">
						<i class="fa fa-times-circle"></i>&nbsp; Error uploading avatar!
					</div>
				';
				break;
			case 3:
				echo '
					<div class="ib_dashboard_form_error bg_green" id="ib_message">
						<i class="fa fa-check-circle"></i>&nbsp; Successfully changed profile avatar!
					</div>
				';
				break;
		}
	}
?>
<script type="text/javascript">
	/* Remove message div instantly */
	function closeMsg() {
	    document.getElementById("ib_message").style.display = "none";
	}

	/* Remove message div after 3 seconds */
	setTimeout(function(){
		$('#ib_message').slideUp("slow");
	}, 3000);
</script>
<?php
	IB_View::getView('user.user_avatar_upload');
	IB_View::getView('user.user_transaction_details');
?>
<div class="ib_wrapper">
	<div class="ib_container">
		<section id="team" style="padding: 50px 0px 20px; text-align: center;">
			<div class="grid">
				<article class="module desktop-4 tablet-12">
					<div class="ib_dev">
						<a href="javascript:void(0)" onclick="openNav()">
							<div class="ib_dev_avatar_btn">
								<i class="fa fa-camera fa-5x"></i>
							</div>
						</a>
						<?php
							$findavatar = 'storage/users/avatar/' . IB_User::getUserData('AV') . '">';
							if (file_exists($findavatar) && !empty(IB_User::getUserData('AV'))) {
								echo '<img class="ib_dev_avatar" src="storage/users/avatar/' . IB_User::getUserData('AV') . '">';
							} elseif (!file_exists($findavatar) && empty(IB_User::getUserData('AV'))) {echo '<img class="ib_dev_avatar" src="storage/users/avatar/default.jpg">';
							} else {
								echo '<img class="ib_dev_avatar" src="storage/users/avatar/default.jpg">';
							}
						?>
					</div>
					<h3 class="ib_dev_name">
						<?php
							echo IB_User::getUserData('UN');
						?>
					</h3>
					<h5 class="ib_dev_sub">Username</h5>
					<br>
					<h3 class="ib_dev_name">
						<?php
							echo IB_User::getUserData('EM');
						?>
					</h3>
					<h5 class="ib_dev_sub">Email</h5>
					<!-- <br>
					<h3 class="ib_dev_name">
						Not verified
					</h3>
					<h5 class="ib_dev_sub"><i class="fa fa-exclamation-circle"></i> Account not verified</h5> -->
				</article>
				<article class="module desktop-8 tablet-12">
					<div class="grid">
						<article class="module desktop-12 tablet-12" style="margin-bottom: 0;">
							<h1 class="ib_dev_high"><i class="fa fa-user"></i> Customer Information 
							<a href="user.php?tab=edit"><span class="ib_dev_high_btn">Edit Profile</span></a></h1>
						</article>
						<article class="module desktop-7 tablet-12">
							<?php
								if (IB_Transaction::checkPending()) {
									echo '
										<div class="ib_featured_label bg_green">
											<span class="ib_featured_new"></span><i class="fa fa-refresh"></i> Pending Transactions
										</div>
									';
								}
							?>
							<?php
								if (IB_Transaction::checkPending()) {
										$data = IB_Transaction::getTransactions();
										$newdata = json_decode($data[2], true);
										echo '<div class="ib_user_information">';
										echo '
											<div class="ib_user_name">' . $newdata['transaction_summary'][0] . '</div>
											<div class="ib_user_sub">Transaction ID</div>
										';
										echo '
											<div class="ib_user_name">PHP ' . $newdata['transaction_summary'][1] . '</div>
											<div class="ib_user_sub">Amount to pay</div>
										';
										echo '
											<div class="ib_user_name">' . $newdata['transaction_summary'][2] . '</div>
											<div class="ib_user_sub">Expected date</div>
										';
										echo '<div style="float: right; margin: -10px -10px;"><a href="javascript:void(0)" onclick="viewDetails()"><span class="ib_cart_item_btn bg_blue">View full details</span></a></div>';
										echo '</div>';
								}
							?>
							<div class="ib_featured_label bg_green">
								<span class="ib_featured_new"></span><i class="fa fa-tasks"></i> Recent Transactions
							</div>
							<?php
								if (IB_Transaction::checkRecent()) {
										$data = IB_Transaction::getRecentTransactions()[0];
										$newdata = json_decode($data[2], true);
										echo '<div class="ib_user_information">';
										echo '
											<div class="ib_user_name">' . $newdata['transaction_summary'][0] . '</div>
											<div class="ib_user_sub">Transaction ID</div>
										';
										echo '
											<div class="ib_user_name">PHP ' . $newdata['transaction_summary'][1] . '</div>
											<div class="ib_user_sub">Amount to pay</div>
										';
										echo '
											<div class="ib_user_name">' . $newdata['transaction_summary'][2] . '</div>
											<div class="ib_user_sub">Expected date</div>
										';
										echo '</div>';
								} else {
									echo '<p>No recent transactions :(</p>';
								}
							?>
						</article>
						<article class="module desktop-5 tablet-12">
							<div class="ib_featured_label bg_green">
								<span class="ib_featured_new"></span><i class="fa fa-user"></i> Personal information
							</div>
							<?php
								if (IB_UserInfo::checkUserInfo()) {
									echo '
										<div class="ib_user_information">
											<div class="ib_user_name">' . IB_UserInfo::getUserInfo('FN') . ' ' . IB_UserInfo::getUserInfo('MN') . ' ' . IB_UserInfo::getUserInfo('LN') . '</div>
											<div class="ib_user_sub">Full Name</div>
											<div class="ib_user_name">' . IB_UserInfo::getUserInfo('AD') . '</div>
											<div class="ib_user_sub">Shipping Address</div>
											<div class="ib_user_name">' . IB_UserInfo::getUserInfo('CN') . '</div>
											<div class="ib_user_sub">Contact Number</div>
										</div>
									';
								} else {
									echo '<p>No personal information :(</p>';
								}
							?>
						</article>
					</div>
				</article>
			</div>
		</section>
	</div>
</div>