<?php
	require_once 'app/ib_init.php';

	if (isset($_GET['slug']) && !empty($_GET['slug']) && in_array(strtoupper($_GET['slug']), IB_Product::getProductsLabel())) {
		// Able to access
	} else {
		// throw an error to error page
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo IB_Product::getProductBySlug($_GET['slug'])[1];?> &sdot; G-Shock Warriors</title>
		<link rel="stylesheet" type="text/css" href="css/ib_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_auth_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_grid_style.min.css">
	</head>
	<body class="bg_lg">
		<?php
			IB_View::getView('navigation.header');
		?>
		<div class="ib_wrapper">
			<div class="ib_content">
				<script type="text/javascript">
					/* Remove message div after 3 seconds */
					setTimeout(function(){
						$('#ib_message').fadeOut("slow");
					}, 3000);
				</script>
				<section class="ib_body">
					<div class="grid">
						<?php
							IB_View::getView('navigation.side_panel');
							IB_View::getView('navigation.user_panel');
						?>
						<article class="module desktop-9 tablet-12">
							<div class="ib_featured">
								<div class="grid">
									<?php
										if (isset($_POST['push_to_cart'])) {
											echo '<article class="module desktop-12 tablet-12">';
											$id = IB_Database::IB_Escape($_POST['id']);
											$label = IB_Database::IB_Escape($_POST['name']);
											$price = IB_Database::IB_Escape($_POST['price']);
											$uid = IB_User::checkUser();
											$data = IB_Cart::put(array($id, $label, $price, 1));
											if (empty($id) || empty($label) || empty($price)) {
												echo '
													<div class="ib_dashboard_form_error bg_red" id="ib_message">
														<i class="fa fa-times-circle"></i>&nbsp; Error adding item to cart!
													</div>
												';
											} else {
												if (IB_Cart::checkIfExists($label, $uid)) {
													echo '
														<div class="ib_dashboard_form_error bg_blue" id="ib_message">
															<i class="fa fa-exclamation-triangle"></i>&nbsp; Item already on the cart! <a href="./cart.php"><span class="ib_product_alt_cart_btn bg_dark"><i class="fa fa-shopping-bag"></i>&nbsp; View cart</span></a>
														</div>
													';
												} else {
													$json = json_encode($data, true);
													IB_Database::IB_Query("INSERT INTO `" . IB_Cart::getTable() . "` (`c_uid`, `c_content`) VALUES ('{$uid}', '{$json}')");
													echo '
														<div class="ib_dashboard_form_error bg_green" id="ib_message">
															<i class="fa fa-check-circle"></i>&nbsp; Successfully added to shopping cart! <a href="./cart.php"><span class="ib_product_alt_cart_btn bg_dark"><i class="fa fa-shopping-bag"></i>&nbsp; View cart</span></a>
														</div>
													';
												}
											}
											echo '</article>';
										}
									?>
									<section style="padding: 20px 0px;">
										<article class="module desktop-5 tablet-12">
											<img class="ib_thumbnail_l" src="storage/products/<?php echo IB_Product::getProductBySlug($_GET['slug'])[6];?>.png">
										</article>
										<article class="module desktop-7 tablet-12">
											<form action="" method="POST">
											<input type="hidden" name="id" value="<?php echo IB_Product::getProductBySlug($_GET['slug'])[0];?>">
											<input type="hidden" name="name" value="<?php echo IB_Product::getProductBySlug($_GET['slug'])[1];?>">
											<input type="hidden" name="price" value="<?php echo IB_Product::getProductBySlug($_GET['slug'])[3];?>">
											<?php
												if (empty(IB_Product::getProductBySlug($_GET['slug'])[5])) {
													$cat = '';
												} else {
													$cat = ' (' . IB_Product::getProductBySlug($_GET['slug'])[5] . ')';
												}
											?>
											<h1 class="ib_product_alt_label"><?php echo IB_Product::getProductBySlug($_GET['slug'])[1];?></h1>
											<span class="ib_product_alt_cat"><?php echo IB_Collection::getCollectionLabel(IB_Product::getProductBySlug($_GET['slug'])[4])[0] . $cat;?> </span>
											<div class="ib_product_alt_hr"></div>
											<p class="ib_product_alt_desc"><?php echo IB_Product::getProductBySlug($_GET['slug'])[2];?></p>
											<div class="ib_product_alt_hr"></div><br>
											<?php
												if (IB_Token::checkToken()) {
													if (IB_Role::checkRoleIfAdmin(IB_User::getUserData('RID'))) {
														// NO CART BUTTON
													} else {
														echo '<button name="push_to_cart" class="ib_product_alt_btn bg_green"><i class="fa fa-shopping-bag"></i>&nbsp; Add to cart</button>';
														echo '
															<h1 class="ib_product_alt_price">PHP ' . number_format(IB_Product::getProductBySlug($_GET['slug'])[3], 2) . '
															</h1>
														';
													}
												} else {
													echo '
														<h1 class="ib_product_alt_price">PHP ' . number_format(IB_Product::getProductBySlug($_GET['slug'])[3], 2) . '
														</h1><br>
													';
													echo '
														<a href="./signin.php?r=' . $_SERVER['REQUEST_URI'] . '" class="ib_product_alt_auth_btn bg_green"><i class="fa fa-sign-in"></i>&nbsp; Sign in
														</a>
														<a href="./signup.php?r=' . $_SERVER['REQUEST_URI'] . '" class="ib_product_alt_auth_btn bg_green"><i class="fa fa-user"></i>&nbsp; Sign up
														</a>
														<br>
														<span class="ib_product_alt_auth_msg"><i class="fa fa-exclamation-circle"></i> To continue shopping, you need to sign in first or create an account</span>
													';
												}
											?>
											</form>
										</article>
									</section>
								</div>
							</div>
						</article>
					</div>
				</section>
			</div>
		</div>
	</body>
</html>