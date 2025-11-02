<script type="text/javascript">
	/* Open when someone clicks on the span element */
	function viewDetails() {
	    document.getElementById("myTransaction").style.width = "100%";
	}

	/* Close when someone clicks on the "x" symbol inside the overlay */
	function closeDetails() {
	    document.getElementById("myTransaction").style.width = "0%";
	}
</script>
<div id="myTransaction" class="overlay">

	<!-- Button to close the overlay navigation -->
	<a href="javascript:void(0)" class="closebtn" onclick="closeDetails()">&times;</a>

	<!-- Overlay content -->
	<div class="overlay-content" style="color: #fff;">
		<?php
			if (IB_Transaction::getTransactions()) {
				$data = IB_Transaction::getTransactions();
				$newdata = json_decode($data[2], true);
				// IB_Helper::print($newdata);
				$i = 0;
				echo '
					<div class="ib_cart_item" style="width: 500px; margin: 0px auto;">
						<div class="ib_featured_label bg_green">
							<span class="ib_featured_new"></span><i class="fa fa-file-text-o"></i> Transaction Details
						</div>
				';
				while ($i <= count($newdata['transaction_details']) - 1) {
					echo '
						<div class="grid">
							<a href="product.php?slug=' . strtolower($newdata['transaction_details'][$i][0]) . '">
								<article class="module desktop-3 tablet-3">
									<img class="ib_thumbnail_new" src="storage/products/' . $newdata['transaction_details'][$i][0] . '.png">
								</article>
								<article class=" module desktop-9 tablet-9">
									<div class="ib_cart_holder" style="padding-left: 30px; text-align: left;">
										<span class="ib_cart_item_label">' . $newdata['transaction_details'][$i][0] . '</span><br><br>
										PHP ' . $newdata['transaction_details'][$i][1] . '<br>
											Quantity: ' . $newdata['transaction_details'][$i][2] . '
									</div>
								</article>
							</a>
						</div>
					';
					$i++;
				}
				echo "</div><br>";
			}
		?>
	</div>
</div>