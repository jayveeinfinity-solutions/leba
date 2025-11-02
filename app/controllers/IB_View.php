<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_View {
	
	protected static $root = '/views';

	public static function getRoot() {
		return self::$root;
	}

	public static function getLocationView($view) {
		$array = explode('.', $view);
		$location = self::getRoot() . '/' . $array[0] . '/' . $array[1] . '.temp.php';
		return $location;
	}

	public static function getView($view) {
		$pathway = $_SERVER['DOCUMENT_ROOT'] . self::getLocationView($view);
		if (file_exists($pathway)) {
			include_once $pathway;
		} else {
			throw new Exception("File cannot find ");
		}
	}
}