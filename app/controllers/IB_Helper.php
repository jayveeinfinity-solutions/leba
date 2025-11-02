<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_Helper {
	
	public static function print($array) {
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	public static function IB_OUT_DATE_TIME($timestamp) {
		$str_upload = strtotime($timestamp);
		$date_upload = date("F d, Y - h:i A", $str_upload);
		return $date_upload;
	}

	public static function IB_OUT_DATE($timestamp) {
		$str_upload = strtotime($timestamp);
		$date_upload = date("d-M-y", $str_upload);
		return $date_upload;
	}

	public static function displayDeleteModal($array) {
		if (isset($array['custom']) && $array['custom'] != NULL) {
			$did = $array['custom'];
			$array['custom'] = '&did=' . $did;
		} else {
			$array['custom'] = '';
			$did = $array['id'];
		}
		return '
			<div id="openModal' . $did .'" class="modalDialog">
			    <div class="bg_white" style="text-align: center;">
			    	<a href="#close" title="Close" class="close">X</a>
			    	<h2>Are you sure you want to delete this ' . $array['title'] . '?</h2>
			    	<a href="?tab=' . $array['tab'] . '&action=' . $array['action'] . '&id=' . $array['id'] . $array['custom'] . '"><div class="ib_modal_btn">Yes</div></a><a href="#close"><div class="ib_modal_btn">No</div></a>
			    	<p>This will permanently delete the ' . $array['title'] . ' and cannot be retrieve.</p>
				</div>
			</div>
		';
	}

	public static function throwError403() {
		header('location: /403');
	}

	public static function findImage($image) {
		$findavatar = 'storage/users/avatar/' . $image . '">';
		$default = 'storage/users/avatar/default.jpg';
		if (file_exists($findavatar) && !empty(IB_User::getUserData('AV'))) {
			return $findavatar;
		} elseif (!file_exists($findavatar) && empty(IB_User::getUserData('AV'))) {
			return $default;
		} else {
			return $default;
		}
	}

	public static function showImage($image, $class = null) {
		return '<img class="' . $class . '" style="display: inline-block;" src="' . $image . '" width="60px">';
	}
}