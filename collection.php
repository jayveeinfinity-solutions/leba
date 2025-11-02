<?php
	require_once 'app/ib_init.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Collections &sdot; G-Shock Warriors</title>
		<link rel="stylesheet" type="text/css" href="css/ib_style.min.css">
		<link rel="stylesheet" type="text/css" href="css/ib_grid_style.min.css">
	</head>
	<body class="bg_lg">
		<?php
			IB_View::getView('navigation.header');
		?>
		<div class="ib_wrapper">
			<div class="ib_content">
				<section class="ib_body">
					<div class="grid">
						<?php
							IB_View::getView('navigation.side_panel');
							IB_View::getView('navigation.user_panel');
							
							$collectionsID = IB_Collection::getCollectionsID();
							if (isset($_GET['col']) && !empty($_GET['col']) && in_array($_GET['col'], $collectionsID)) {
									echo '
										<article class="module desktop-9 tablet-12" style="margin-bottom: 5px;"><div class="ib_filters">
									';
									echo 'Filters: ';
									echo '<span class="ib_filters_item bg_dark">' . IB_Collection::getCollectionLabel($_GET['col'])[0] . '</span>';
									echo '
										</div></article>
									';
							}
						?>
						<article class="module desktop-9 tablet-12">
							<div class="ib_featured">
								<div class="ib_featured_label bg_green">
									<span class="ib_featured_new"></span>All watches
									<?php 
									echo '<span class="ib_filters_item bg_dark">' . IB_Collection::getCollectionLabel($_GET['col'])[0] . '</span>';?>
								</div>
								<div class="grid">
									<?php
										$results = IB_Product::getProductsByCollection($_GET['col']);
										$i = 0;
										if (!empty($results)) {
											while ($i <= count($results) - 1) {
												echo '
													<article class="module desktop-4 tablet-12 ib_product_card">
														<a href="product.php?slug=' . strtolower($results[$i][1]) . '"><div class="ib_product">
															<img class="ib_thumbnail_m" src="storage/products/' . $results[$i][6] . '.png">
															<div class="ib_product_details">
																<div class="ib_product_name">' . $results[$i][1] . '<div class="ib_product_collection">' . IB_Collection::getCollectionLabel($results[$i][4])[0] . '</div></div>
																<div class="ib_product_price">PHP ' . number_format($results[$i][3], 2) . '</div>
															</div>
														</div></a>
													</article>
												';
												$i++;
											}
										} else {
											echo '<article class="module desktop-4 tablet-12"><p style="text-indent: 10px;">No results found</p></article>';

										}
									?>
								</div>
							</div>
						</article>
					</div>
				</section>
			</div>
		</div>
	</body>
</html>