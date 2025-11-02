<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_lg">
		<div class="ib_dashboard">
			<h1><i class="fa fa-file-text-o"></i>&nbsp; Transactions</h1>
		</div>
		<div class="ib_content" style="padding: 0px 30px;">
			<script type="text/javascript">
				/* Remove message div after 3 seconds */
				setTimeout(function(){
					$('#ib_message').fadeOut("slow");
				}, 3000);
			</script>
			<?php
				if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'check') {
					$query = IB_Database::IB_Query("UPDATE `" . IB_Transaction::getTable() . "` SET t_status = '1' WHERE t_id = '{$_GET['id']}'");
					echo '
						<div class="ib_dashboard_form_error bg_green" id="ib_message"><i class="fa fa-check-circle"></i>&nbsp; Transaction completed!</div>
					';
				}
				echo "<br>";
				IB_Transaction::viewTable();
			?>
		</div>
	</div>
</article>