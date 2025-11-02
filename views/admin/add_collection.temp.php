<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_gr">
		<div class="ib_dashboard">
			<h1><i class="fa fa-plus"></i> Add Vechile Type &nbsp;<a href="?tab=collections"><span class="ib_dashboard_btn bg_green"><i class="fa fa-arrow-left"></i> Return to vechile types</span></a></h1>
		</div>
		<div class="ib_content">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if (isset($_POST['submit_collection'])) {
					$errors = array();
					$collection = IB_Database::IB_Escape($_POST['collection']);
					if (empty($collection)) {
						$errors[] = '
							<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; Role label is a required field!</div>
						';
					} else {
						$query = IB_Database::IB_Query("SELECT * FROM " . IB_Collection::getTable() . " WHERE col_label = '{$collection}'");
						if (mysqli_num_rows($query) > 0) {
							$errors[] = '
								<div class="ib_dashboard_form_error bg_red" id="ib_message"><i class="fa fa-times-circle"></i>&nbsp; Collection is already exists!</div>
							';
						} else {
							IB_Database::IB_Query("INSERT INTO `" . IB_Collection::getTable() . "` (`col_label`) VALUES ('{$collection}')");
							$errors[] = '
								<div class="ib_dashboard_form_error bg_green" id="ib_message"><i class="fa fa-check-circle"></i>&nbsp; New collection successfully created!</div>
							';
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
				<label class="ib_dashboard_label" for="collection">Vechile type</label>
				<input class="ib_dashboard_input" type="text" name="collection" placeholder="*Vechile type" autocomplete="off" required>
				<br>
				<br>
				<button class="ib_dashboard_button bg_green" name="submit_collection">Save</button>
				<br><br><br>
			</form>
		</div>
	</div>
</article>