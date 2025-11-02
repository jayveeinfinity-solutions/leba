<article class="module desktop-9 tablet-12">
	<div class="ib_wrapper bg_lg ib_scroll">
		<div class="ib_dashboard">
			<h1><i class="fa fa-dashboard"></i> Dashboard</h1>
			<div class="grid">
				<article class="module desktop-4 tablet-12">
					<?php
						IB_App::renderWidget(array(
							'name' => 'cars',
							'link' => 'products',
							'class' => 'IB_Product',
							'icon' => 'fa-car',
							'background' => 'bg_widget_1'
						));
					?>
				</article>
				<article class="module desktop-4 tablet-12">
					<?php
						IB_App::renderWidget(array(
							'name' => 'users',
							'class' => 'IB_User',
							'icon' => 'fa-users',
							'background' => 'bg_widget_2'
						));
					?>
				</article>
				<article class="module desktop-4 tablet-12">
					<?php
						IB_App::renderWidget(array(
							'name' => 'transactions',
							'class' => 'IB_Transaction',
							'icon' => 'fa-file-text-o',
							'background' => 'bg_widget_3'
						));
					?>
				</article>
			</div>
		</div>
	</div>
</article>