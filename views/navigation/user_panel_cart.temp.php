<article class="module desktop-12 tablet-12" style="margin-top: -5px; margin-bottom: -10px;">
	<div class="ib_user_panel bg_darker">
		<ul>
			<a href="./"><li><i class="fa fa-home"></i>&nbsp; Home</li></a>
			<a href="./store.php"><li><i class="fa fa-search"></i>&nbsp; Store</li></a>
			<?php
				if (IB_Token::checkToken()) {
			 		echo '<a href="./user.php"><li class="ib_user_cart"><i class="fa fa-user"></i>&nbsp; My Account</li></a>';
				}
			?>
		</ul>
	</div>
</article>