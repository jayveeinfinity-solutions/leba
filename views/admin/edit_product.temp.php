<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_gr">
		<div class="ib_dashboard">
			<h1><i class="fa fa-pencil"></i> Edit Product &nbsp;<a href="?tab=products"><span class="ib_dashboard_btn bg_green"><i class="fa fa-arrow-left"></i> Return to products</span></a></h1>
		</div>
		<div class="ib_content">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if (isset($_POST['update_product'])) {
					$errors = array();
					$id = $_GET['id'];
					$name = IB_Database::IB_Escape($_POST['name']);
					$description = IB_Database::IB_Escape($_POST['description']);
					$price = IB_Database::IB_Escape($_POST['price']);
					$collection = IB_Database::IB_Escape($_POST['collection']);
					$category = IB_Database::IB_Escape($_POST['category']);
					$new_name = explode('-', $name);
					$scheme = $new_name[0];
					if (empty($name) || empty($description) || empty($price) || empty($collection)) {
						$errors[] = '
							<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; All fields are required!</div>
						';
					} else {
						IB_Database::IB_Query("UPDATE `" . IB_Product::getTable() . "` SET `p_label` = '{$name}', `p_description` = '{$description}', `p_price` = '{$price}', `p_colid` = '{$collection}', `p_category` = '{$category}', `p_color_scheme` = '{$scheme}' WHERE `p_id` = '{$id}'");
						$errors[] = '
							<div class="ib_dashboard_form_error bg_green" id="ib_message"><i class="fa fa-check-circle"></i>&nbsp; Successfully updated product details!</div>
						';
					}
					echo '<div id="ib_message">';
					foreach ($errors as $key => $value) {
						echo $value;
					}
					echo '</div>';
				}
			?><br>
			<form class="ib_dashboard_form bg_white" action="" method="POST" enctype="multipart/form-data">
				<?php $data = IB_Product::getProductByID($_GET['id']);?>
				<label class="ib_dashboard_label" for="name">Product Name</label>
				<input class="ib_dashboard_input" type="text" name="name" placeholder="*Product Name" value="<?php echo $data[1];?>" autocomplete="off" required>
				<label class="ib_dashboard_label" for="descrption">Product Description</label>
				<textarea class="ib_dashboard_textarea" type="text" name="description" placeholder="*Product descrption" required><?php echo $data[2];?></textarea>
				<label class="ib_dashboard_label" for="price">Product price</label>
				<input class="ib_dashboard_input" type="number" name="price" placeholder="*Product price" value="<?php echo $data[3];?>" autocomplete="off" required min="0">
				<label class="ib_dashboard_label" for="collection">Product Collection</label>
				<select class="ib_dashboard_input" name="collection" required>
					<?php
						if(IB_Collection::getCollections()) {
							$data2 = IB_Collection::getCollections('ORDER BY col_label');
							$i = 0;
							while ($i <= count($data2) - 1) {
								if ($data2[$i][0] == $data[4]) {
									echo '<option value="' . $data2[$i][0] . '" selected>' . $data2[$i][1] . '</option>';
								} else {
									echo '<option value="' . $data2[$i][0] . '">' . $data2[$i][1] . '</option>';
								}
								$i++;
							}
						}
					?>
				</select>
				<label class="ib_dashboard_label" for="category">Product category</label>
				<input class="ib_dashboard_input" type="text" name="category" placeholder="Product category" value="<?php echo $data[5];?>" autocomplete="off">
				<br>
				<br>
				<button class="ib_dashboard_button bg_green" name="update_product">Save</button>
				<br><br><br>
			</form>
		</div>
	</div>
</article>