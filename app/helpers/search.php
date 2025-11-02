<?php
	$dir = $_SERVER['DOCUMENT_ROOT'] . '/_clients/leba-basic/';
	require_once $dir . 'app/ib_init.php';

	$request = IB_Database::IB_Escape($_GET['key']);
	$query = IB_Database::IB_Query("SELECT * FROM `" . IB_Product::getTable() . "` WHERE `p_label` LIKE '%" . $request . "%'");
	$data = array();
	if(mysqli_num_rows($query) > 0) {
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			// $data[] = $row['p_label'];
			$col = IB_Collection::getCollectionLabel($row['p_colid']);
			$data[] = '<a href="product.php?slug=' . strtolower($row['p_label']) . '"><div class="tt-suggest"><img class="tt-suggest-xs" src="storage/products/' . $row['p_color_scheme'] . '.png"><div class="tt-suggest-label">' . $row['p_label'] . ' <span class="tt-suggest-col bg_dark">' . $col[0] . '</span><p class="tt-suggest-price">PHP ' . number_format($row['p_price'], 2) . '</p></div></div><a>';
		}
	}
	echo json_encode($data);
?>