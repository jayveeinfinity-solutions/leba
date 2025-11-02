<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_gr">
		<div class="ib_dashboard">
			<h1><i class="fa fa-plus"></i> Add Car &nbsp;<a href="?tab=products"><span class="ib_dashboard_btn bg_green"><i class="fa fa-arrow-left"></i> Return to cars</span></a></h1>
		</div>
		<div class="ib_content">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if (isset($_POST['submit_product'])) {
					$errors = array();
					$name = IB_Database::IB_Escape($_POST['name']);
					$description = IB_Database::IB_Escape($_POST['description']);
					$price = IB_Database::IB_Escape($_POST['price']);
					$collection = IB_Database::IB_Escape($_POST['collection']);
					$category = IB_Database::IB_Escape($_POST['category']);
					$new_name = explode('-', $name);
					$scheme = $new_name[0];
					$avatarEXT = array("gif", "jpeg", "jpg", "png");
				    $temp = explode(".", $_FILES["image"]["name"]);
				    $extension = end($temp);
				    $is_passed = FALSE;
				    if ((($_FILES["image"]["type"] == "image/gif")
				    	|| ($_FILES["image"]["type"] == "image/jpeg")
				    	|| ($_FILES["image"]["type"] == "image/jpg")
				    	|| ($_FILES["image"]["type"] == "image/pjpeg")
				    	|| ($_FILES["image"]["type"] == "image/x-png")
				    	|| ($_FILES["image"]["type"] == "image/png"))
				    	&& ($_FILES["image"]["size"] < 2097152)
				    	&& in_array($extension, $avatarEXT)) {
				        if ($_FILES["image"]["error"] > 0) {
							$errors[] = '
								<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; Error: ' . $_FILES["image"]["error"] . '</div>
							';
				        } else {
				        	$newname = $name . '.' . $extension;
				        	$is_passed = TRUE;
				        }
				    } else {
						$errors[] = '
							<div class="ib_dashboard_form_error bg_blue" id="ib_message"><i class="fa fa-exclamation-triangle"></i>&nbsp; Error: Thumbnail maximum file size must be 2 MB and in GIF, JPG, and PNG image format.</div>
						';
				    }
					if (empty($name) || empty($description) || empty($price) || empty($collection)) {
						$errors[] = '
							<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; All fields are required!</div>
						';
					} else {
						$query = IB_Database::IB_Query("SELECT * FROM " . IB_Product::getTable() . " WHERE p_label = '{$name}'");
						if (mysqli_num_rows($query) > 0) {
							$errors[] = '
								<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; Product is already exists!</div>
							';
						} else {
							if ($is_passed) {
								IB_Database::IB_Query("INSERT INTO `" . IB_Product::getTable() . "` (`p_label`, `p_description`, `p_price`, `p_colid`, `p_category`, `p_color_scheme`) VALUES ('{$name}', '{$description}', '{$price}', '{$collection}', '{$category}', '{$scheme}')");
								move_uploaded_file($_FILES["image"]["tmp_name"], "storage/products/" . $newname);

								$errors[] = '
									<div class="ib_dashboard_form_error bg_green" id="ib_message"><i class="fa fa-check-circle"></i>&nbsp; New product successfully created!</div>
								';
							} else {
								IB_Database::IB_Query("INSERT INTO `" . IB_Product::getTable() . "` (`p_label`, `p_description`, `p_price`, `p_colid`, `p_category`, `p_color_scheme`) VALUES ('{$name}', '{$description}', '{$price}', '{$collection}', '{$category}', '{$scheme}')");
								$errors[] = '
									<div class="ib_dashboard_form_error bg_green" id="ib_message"><i class="fa fa-check-circle"></i>&nbsp; New product successfully created!</div>
								';
							}
							
						}
					}
					echo '<div id="ib_message">';
					foreach ($errors as $key => $value) {
						echo $value;
					}
					echo '</div>';
				}
			?><br>
			<form class="ib_dashboard_form bg_white" action="" method="POST" enctype="multipart/form-data">
				<label class="ib_dashboard_label" for="category">Car Brand</label>
				<input class="ib_dashboard_input" type="text" name="category" placeholder="*Car Brand" autocomplete="off" required>
				<label class="ib_dashboard_label" for="name">Car Model</label>
				<input class="ib_dashboard_input" type="text" name="name" placeholder="*Car Model" autocomplete="off" required>
				<label class="ib_dashboard_label" for="descrption">Car Description</label>
				<textarea class="ib_dashboard_textarea" type="text" name="description" placeholder="*Car descrption" required></textarea>
				<label class="ib_dashboard_label" for="price">Car price</label>
				<input class="ib_dashboard_input" type="number" name="price" placeholder="*Car price" autocomplete="off" required min="0">
				<label class="ib_dashboard_label" for="collection">Car Vehicle Type</label>
				<select class="ib_dashboard_input" name="collection" required>
					<?php
						if(IB_Collection::getCollections()) {
							$data = IB_Collection::getCollections('ORDER BY col_label');
							$i = 0;
							while ($i <= count($data) - 1) {
								echo '<option value="' . $data[$i][0] . '">' . $data[$i][1] . '</option>';
								$i++;
							}
						}
					?>
				</select>
				<label class="ib_dashboard_label" for="image">Car Image</label>
				<input class="ib_dashboard_input" type="file" name="image" required>
				<br>
				<br>
				<button class="ib_dashboard_button bg_green" name="submit_product">Save</button>
				<br><br><br>
			</form>
		</div>
	</div>
</article>