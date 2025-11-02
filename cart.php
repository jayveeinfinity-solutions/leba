<?php
	require_once 'app/ib_init.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Cart &sdot; <?php echo IB_Config::get('info/appname');?></title>
		<link rel="stylesheet" type="text/css" href="css/ib_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_user_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_grid_style.min.css">
        <link rel="icon" type="image/png" href="storage/favicon.png">
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
							IB_View::getView('navigation.user_panel_cart');
						?>
						<?php
							if (isset($_POST['apply_quantity'])) {
								echo '<article class="module desktop-12 tablet-12" style="margin-top: 5px; margin-bottom: 0px;">';
								$id = IB_Database::IB_Escape($_POST['key']);
								$init_qty = IB_Database::IB_Escape($_POST['init_qty']);
								$qty = IB_Database::IB_Escape($_POST['quantity']);
								$uid = IB_User::checkUser();
								if (empty($id) || empty($init_qty) || empty($qty)) {
									echo '
										<div class="ib_dashboard_form_error bg_red" id="ib_message">
											<i class="fa fa-times-circle"></i>&nbsp; Error changing quantity!
										</div>
									';
								} else {
									if ($init_qty === $qty) {
										echo '
											<div class="ib_dashboard_form_error bg_blue" id="ib_message">
												<i class="fa fa-exclamation-triangle"></i>&nbsp; No changes to item quantity!
											</div>
										';
									} else {
										$newdata = json_encode(IB_Cart::changedQuantity($id, $qty)[2], true);
										IB_Database::IB_Query("UPDATE `" . IB_Cart::getTable() . "` SET c_content = '{$newdata}' WHERE c_id = '{$id}' AND c_uid = '{$uid}'");
										echo '
											<div class="ib_dashboard_form_error bg_green" id="ib_message">
												<i class="fa fa-check-circle"></i>&nbsp; Successfully changed quantity to (' . $qty . ')!
											</div>
										';
									}
								}
								echo '</article>';
							}
							if (isset($_POST['remove_item'])) {
								echo '<article class="module desktop-12 tablet-12" style="margin-top: 5px; margin-bottom: 0px;">';
								$id = IB_Database::IB_Escape($_POST['key']);
								$uid = IB_User::checkUser();
								if (empty($id)) {
									echo '
										<div class="ib_dashboard_form_error bg_red" id="ib_message">
											<i class="fa fa-times-circle"></i>&nbsp; Error removing of item!
										</div>
									';
								} else {
									IB_Database::IB_Query("DELETE FROM `" . IB_Cart::getTable() . "` WHERE c_id = '{$id}' AND c_uid = '{$uid}'");
									echo '
										<div class="ib_dashboard_form_error bg_green" id="ib_message">
											<i class="fa fa-check-circle"></i>&nbsp; Successfully remove from the cart!
										</div>
									';
								}
								echo '</article>';
							}
						?>
						<article class="module desktop-1 tablet-12">
						</article>
						<article class="module desktop-6 tablet-12">
							<div class="ib_featured">
								<div class="ib_featured_label bg_green">
									<span class="ib_featured_new"></span><i class="fa fa-shopping-bag"></i>&nbsp; Shopping Cart items 
									<?php
										if (IB_Token::checkToken()) {
											if (IB_Cart::count(IB_User::checkUser())) {
												echo '<span class="ib_user_cart_count bg_dark">' . IB_Cart::count() . '</span>';
											} else {
												echo '<span class="ib_user_cart_count bg_dark">0</span>';
											}
										} else {
											echo '<span class="ib_user_cart_count bg_dark">0</span>';
										}
									?>
								</div>
								<?php
									if (IB_Token::checkToken()) {
										if (IB_Cart::count()) {
											$data = IB_Cart::getCart(IB_Cart::get());
											$i = 0;
											while ($i <= count($data) - 1) {
												$opt = 1;
												$options = '';
												while ($opt <= 5) {
													if ($data[$i][5] == $opt) {
														$options .= '<option value="' . $data[$i][5] . '" selected>' . $data[$i][5] . '</option>';
													} else {
														$options .= '<option value="' . $opt . '">' . $opt . '</option>';
													}
													$opt++;
												}
												echo '
													<div class="ib_cart_item">
														<div class="grid">
															<article class="module desktop-3 tablet-3">
																<img class="ib_thumbnail_new" src="storage/products/' . IB_Product::getProductByID($data[$i][2])[6] . '.png">
															</article>
															<article class=" module desktop-9 tablet-9">
																<div class="ib_cart_holder">
																	<span class="ib_cart_item_label">' . $data[$i][3] . '</span><br><br>
																	PHP ' . number_format($data[$i][4], 2) . '<br>

																	<form action="" method="POST">
																		<input type="hidden" name="key" value="' . $data[$i][0] . '">
																		<input type="hidden" name="init_qty" value="' . $data[$i][5] . '">
																		Quantity: 
																		<select name="quantity">
																			' . $options . '
																		</select><br><br>
																		<button class="ib_cart_item_btn bg_blue" name="apply_quantity">Change</button>
																		<button class="ib_cart_item_btn bg_red" name="remove_item">Remove</button>
																	</form>
																</div>
															</article>
														</div>
													</div>
												';
												$i++;
											}
											echo "<br>";
										} else {
											echo '<p>No items on the bag :(</p>';
										}
									} else {
										echo '<p>No items on the bag :(</p>';
									}
								?>
								<a href="./store.php"><span class="bg_green" style="padding: 5px 10px; color: #fff; border: 1px solid #ddd; border-radius: 3px;">Continue shopping</span></a>
							</div>
						</article>
						<article class="module desktop-4 tablet-12">
							<div class="ib_featured">
								<div class="ib_featured_label bg_green">
									<span class="ib_featured_new"></span><i class="fa fa-shopping-bag"></i>&nbsp; Cart Summary
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
															<td>' . number_format($data[$i][4], 2) . '</td>
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
											echo '<br>
												<div class="ib_dashboard_info_message bg_green">
													Total payment to pay<br>
													<div class="ib_cart_total">
														PHP ' . IB_Cart::getTotalPayment() . '
													</div>
												</div>
											';
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
										if (IB_Cart::count()) {
											if (!IB_Transaction::checkPending()) {
												echo '
													<a href="checkout.php"><div class="ib_cart_check_btn">
														Proceed to checkout
													</div></a>
												';
											} else {
												echo '<p><i class="fa fa-info-circle"></i> You are not able to checkout this cart because you have pending transactions!</p>';
											}
										}
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
						<article class="module desktop-1 tablet-12">
						</article>
					</div>
				</section>
			</div>
		</div>
	</body>
</html>