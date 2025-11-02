<article class="module desktop-3 tablet-12">
	<div class="ib_side_panel">
		<div class="ib_side_main_label bg_green">Collections</div>
		<?php
			$collections = IB_Collection::getCollections();
			$collectionsID = IB_Collection::getCollectionsID();

			if($collections) {
				$i = 0;
					while ($i <= count($collections) - 1) {
						if (isset($_GET['col']) && !empty($_GET['col']) && in_array($_GET['col'], $collectionsID)) {
							if ($collections[$i][0] === $_GET['col']) {
								
								echo '
									<div class="ib_side_label_active">' . $collections[$i][1] . '</div>
								';
							} else {
								echo '
									<a href="collection.php?col=' . $collections[$i][0] . '">
										<div class="ib_side_label">' . $collections[$i][1] . '</div>
									</a>
								';
							}
						} else {
								echo '
									<a href="collection.php?col=' . $collections[$i][0] . '">
										<div class="ib_side_label">' . $collections[$i][1] . '</div>
									</a>
								';
							}
					$i++;
				}
			}
		?>
	</div>
</article>