
<article class="module desktop-12 tablet-12" style="margin-top: -5px; margin-bottom: -10px;">
	<div class="ib_user_panel bg_darker">
		<ul>
			<a href="./"><li><i class="fa fa-home"></i>&nbsp; Home</li></a>
			<a href="./store.php"><li><i class="fa fa-search"></i>&nbsp; Store</li></a><!-- 
			<li><i class="fa fa-tasks"></i>&nbsp; Checkouts</li> -->
			<?php
				if (IB_Token::checkToken()) {
					if (IB_Role::checkRoleIfAdmin(IB_User::getUserData('RID'))) {
						// NO CART DETAILS
					} else {
						if (IB_Cart::count()) {
							$count = '<span class="ib_user_cart_count bg_dark">' . IB_Cart::count() . '</span>';
						} else {
							$count = '<span class="ib_user_cart_count bg_dark">0</span>';
						}
						echo '
							<a href="./cart.php"><li class="ib_user_cart"><i class="fa fa-money"></i>&nbsp; PHP ' . IB_Cart::getTotalPayment() . '</li><li class="ib_user_cart bg_green"><i class="fa fa-shopping-bag"></i>&nbsp; Shopping Cart ' . $count . '
								</li></a>';
					}
				} else {
					echo '
						<a href="./cart.php"><li class="ib_user_cart"><i class="fa fa-money"></i>&nbsp; PHP ' . IB_Cart::getTotalPayment() . '</li><li class="ib_user_cart bg_green"><i class="fa fa-shopping-bag"></i>&nbsp; Shopping Cart ' . $count . '
							</li></a>';
				}
			?>
		</ul>
	</div>
</article>