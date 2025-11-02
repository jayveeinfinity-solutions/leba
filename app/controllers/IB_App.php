<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_App {

	public static function renderWidget($data) {
		$singular = rtrim($data['name'], 's');
		if ($data['class']::count() > 1) {
			$msg = '<h3>' . $data['class']::count() . ' ' . ucfirst($data['name']) . '</h3>';
		} else {
			$msg = '<h3>' . $data['class']::count() . ' ' . ucfirst($singular) . '</h3>';
		}
		echo '
			<div class="ib_dashboard_holder ' . $data['background'] . '">
				<div class="bg_overlay overlay_content">
					<div class="ib_dashboard_icon">
						<i class="fa ' . $data['icon'] . ' fa-4x"></i>
					</div>
						' . $msg . '
						<p>
							There are ' . $data['class']::count() . ' ' . $singular . ($data['class']::count() > 1 ? 's' : '') . ' in ' . IB_Config::get('info/appname') . '.<br>To view ' . $singular . ($data['class']::count() > 1 ? 's' : '') . ', click the button below<br><br>
						</p>
					<a href="?tab=' . (isset($data['link']) ? $data['link'] : $data['name']) . '">
						<div class="ib_dashboard_overlay_btn bg_green">
							View all ' . $data['name'] . '
						</div>
					</a>
				</div>
			</div>
		';
	}
}