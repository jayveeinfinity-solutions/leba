<?php
	require_once 'app/ib_init.php';

	if (IB_Cart::count()) {
		if (!IB_UserInfo::checkUserInfo()) {
			header('location: 403');
		}
	} else {
		header('location: 403');
	}

	$token = IB_Token::generateToken('MIXED', 16);
	$end = strtotime(date('Y-m-d') . ' + 5 days');
	$db_date = date('Y-m-d', $end);
	$date = date('F m, Y', $end);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Thank you &sdot; G-Shock Warriors</title>
		<link rel="stylesheet" type="text/css" href="css/ib_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_user_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_grid_style.min.css">
	</head>
	<body class="bg_lg">
		<script type="text/javascript">
			/* Remove message div after 3 seconds */
			setTimeout(function(){
				$('#ib_message').fadeOut("slow");
			}, 3000);
		</script>
		<?php
			IB_View::getView('navigation.header');
		?>
		<div class="ib_wrapper">
			<div class="ib_content">
				<section class="ib_body">
					<div class="grid">
						<?php
							if (isset($_POST['confirm_check'])) {
								$id = IB_User::checkUser();
								$trackid = IB_Database::IB_Escape($_POST['token']);
								$payment = IB_Database::IB_Escape($_POST['payment']);
								$dbdate = IB_Database::IB_Escape($_POST['date']);

								$fullname = IB_Database::IB_Escape($_POST['fullname']);
								$address = IB_Database::IB_Escape($_POST['address']);
								$contact = IB_Database::IB_Escape($_POST['contact']);

								$transaction['transaction_summary'] = array($trackid, $payment, $dbdate);
								$row = IB_Cart::getCart(IB_Cart::get());
								$i = 0;
								while ($i <= count($row) - 1) {
									$transaction['transaction_details'][] = array($row[$i][3], $row[$i][4], $row[$i][5]);
									$i++;
								}
								$transaction['transaction_user_information'] = array($fullname, $address, $contact);
								IB_Transaction::push($transaction);
							}
						?>
						<article class="module desktop-1 tablet-12">
						</article>
						<?php
							if (!IB_Transaction::checkPending()) {
						?>
						<article class="module desktop-6 tablet-12">
							<div class="ib_featured">
								<div class="ib_featured_label bg_green">
									<span class="ib_featured_new"></span><i class="fa fa-file-text-o"></i>&nbsp; Transaction Summary
								</div>
								<div class="ib_user_information">
									<div class="ib_user_sub">Transaction ID:</div>
									<div class="ib_user_name"><?php echo $token;?></div><br>
									<div class="ib_user_sub">Payment:</div>
									<div class="ib_user_name">PHP <?php echo IB_Cart::getTotalPayment();?></div><br>
									<div class="ib_user_sub">Expected date to ship:</div>
									<div class="ib_user_name"><?php echo $date;?></div>
								</div>
								<form action="" method="POST">
								<input type="hidden" name="token" value="<?php echo $token;?>">
								<input type="hidden" name="payment" value="<?php echo IB_Cart::getTotalPayment();?>">
								<input type="hidden" name="date" value="<?php echo $db_date;?>">

								<input type="hidden" name="fullname" value="<?php echo IB_UserInfo::getUserInfo('FN') . ' ' . IB_UserInfo::getUserInfo('MN') . ' ' . IB_UserInfo::getUserInfo('LN');?>">
								<input type="hidden" name="address" value="<?php echo IB_UserInfo::getUserInfo('AD');?>">
								<input type="hidden" name="contact" value="<?php echo IB_UserInfo::getUserInfo('CN');?>">
								<button class="ib_check_btn" name="confirm_check">Confirm details</button>
								</form>
							</div>
						</article>
						<article class="module desktop-4 tablet-12">
							<div class="ib_featured">
								<div class="ib_featured_label bg_green">
									<span class="ib_featured_new"></span><i class="fa fa-file-text-o"></i>&nbsp; Transaction Details
								</div>
								<?php
									if (IB_Token::checkToken()) {
										if (IB_Cart::count()) {
											$data = IB_Cart::getCart(IB_Cart::get());
											$i = 0;
											echo '
												<table class="ib_cart_summary_tbl">
													<thead>
														<tr>
															<th>Name</th>
															<th>Price</th>
															<th></th>
															<th>Quantity</th>
															<th>Sub Total</th>
														</tr>
													</thead>
												';
											$subprice = 0;
											$subqty = 0;
											$subtotal = 0;
											while ($i <= count($data) - 1) {
												echo '
													<tbody>
														<tr>
															<td>' . $data[$i][3] . '</td>
															<td>' . $data[$i][4] . '</td>
															<td> x </td>
															<td>' . $data[$i][5] . '</td>
															<td>' . $data[$i][4] * $data[$i][5] . '</td>
														</tr>
													</tbody>
												';
												$subprice += $data[$i][4];
												$subqty += $data[$i][5];
												$subtotal += $data[$i][4] * $data[$i][5];
												$i++;
											}
											echo '
												<tboby>
													<tr style="font-weight: bold;">
														<td>Total </td>
														<td>' . IB_Cart::getSubTotal() . '</td>
														<td> x </td>
														<td>' . IB_Cart::getTotalQuantity() . '</td>
														<td>' . IB_Cart::getTotalPayment() . '</td>
													</tr>
												</tbody>
											';
											echo '</table>';
										} else {
											echo '<p>No cart summary :(</p>';
										}
									} else {
										echo '<p>No cart summary :(</p>';
									}
								?>
							</div>
							<?php
								if (IB_Token::checkToken()) {
							?>
								<div class="ib_featured">
									<?php
									if (IB_UserInfo::checkUserInfo()) {
										echo '
											<div class="ib_featured_label bg_green">
												<span class="ib_featured_new"></span><i class="fa fa-user"></i>&nbsp; Customer Information
											</div>
										';
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
										echo '
											<div class="ib_dashboard_info_message bg_green">
												Total payment to pay<br>
												<div class="ib_cart_total">
													PHP ' . IB_Cart::getTotalPayment() . '
												</div>
											</div>
										';
									} else {
										echo '
											<br>
											<div class="ib_dashboard_info_message bg_blue">
												No personal information!<br>
												<span>To proceed checkout, kindly configure first personal information.<br><a href="user.php?tab=edit">Update your information now!</a></span>
											</div>
										';
									}
								?>
							</div>
							<?php
								}
							?>
						</article>
							<?php
								} else {
									echo '<article class="module desktop-10 tablet-10" style="text-align: center;">';
									echo '<div class="ib_transaction_pending">Thank you!</div>';
									echo '<div class="ib_transaction_message"><i class="fa fa-exclamation-circle"></i> You cannot proceed to checkout another transaction unless you had to pending transactions</div><br><br><br>';
									echo '<a href="user.php"><div class="ib_transaction_btn bg_green">View my transaction</div></a>';
									echo '</article>';
								}
							?>
						<article class="module desktop-1 tablet-12">
						</article>
					</div>
				</section>
			</div>
		</div>
	</body>
</html>