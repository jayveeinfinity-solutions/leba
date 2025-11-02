<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_lg">
		<div class="ib_dashboard">
			<h1><i class="fa fa-file-text-o"></i>&nbsp; Transaction &nbsp;<a href="?tab=transactions"><span class="ib_dashboard_btn bg_green"><i class="fa fa-arrow-left"></i> &nbsp; Return to transaction</span></a></h1>
		</div>
		<div class="ib_content" style="padding: 0px 30px;">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if (IB_Transaction::getTransactionByID($_GET['id'])) {
					$data = IB_Transaction::getTransactionByID($_GET['id']);
					$newdata = json_decode($data[2], true);
					// IB_Helper::print($newdata);
					$i = 0;
					echo '
						<div class="grid">
							<article class="module desktop-6 tablet-6">
								<div class="ib_featured_label bg_green">
									<span class="ib_featured_new"></span><i class="fa fa-file-text-o"></i> Transaction Summary
								</div>
								<div class="ib_user_information">
									<div class="ib_user_name">' . $newdata['transaction_summary'][0] . '</div>
									<div class="ib_user_sub">Transaction ID</div>
									<div class="ib_user_name">PHP ' . $newdata['transaction_summary'][1] . '</div>
									<div class="ib_user_sub">Amount to pay</div>
									<div class="ib_user_name"> ' . IB_Helper::IB_OUT_DATE($newdata['transaction_summary'][2]) . '</div>
									<div class="ib_user_sub">Expected date</div>
								</div>
							</article>
							<article class="module desktop-6 tablet-6">
								<div class="ib_featured_label bg_green">
									<span class="ib_featured_new"></span><i class="fa fa-file-text-o"></i> Transaction User Information
								</div>
								<div class="ib_user_information">
									<div class="ib_user_name">' . $newdata['transaction_user_information'][0] . '</div>
									<div class="ib_user_sub">Fullname</div>
									<div class="ib_user_name">' . $newdata['transaction_user_information'][1] . '</div>
									<div class="ib_user_sub">Shipping Address</div>
									<div class="ib_user_name">' . $newdata['transaction_user_information'][2] . '</div>
									<div class="ib_user_sub">Contact Number</div>
								</div>
							</article>
						</div>
					';
					echo '
						<div class="ib_cart_item" style="width: 100%; margin: 0px auto;">
							<div class="ib_featured_label bg_green">
								<span class="ib_featured_new"></span><i class="fa fa-file-text-o"></i> Transaction Details
							</div>
					';
					while ($i <= count($newdata['transaction_details']) - 1) {
						echo '
							<div class="grid">
								<a href="product.php?slug=' . strtolower($newdata['transaction_details'][$i][0]) . '">
									<article class="module desktop-3 tablet-3">
										<img class="ib_thumbnail_s" src="storage/products/' . $newdata['transaction_details'][$i][0] . '.png">
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
</article>