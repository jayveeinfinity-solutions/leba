<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_Cart {

	protected static $table = 'cart_tbl';
	protected static $cart = array();

	public static function count() {
		if (IB_Token::checkToken()) {
			$key = IB_User::checkUser();
			$query = IB_Database::IB_Query("SELECT * FROM `" . self::getTable() . "` WHERE c_uid = '{$key}' AND c_tid IS NULL");
			if (mysqli_num_rows($query) > 0) {
				return mysqli_num_rows($query);
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public static function checkIfExists($name, $key) {
		$data = self::get();
		$query = IB_Database::IB_Query("SELECT * FROM `" . self::getTable() . "` WHERE c_uid = '{$key}' AND c_content LIKE '%" . $name . "%' AND c_tid IS NULL");
		if (mysqli_num_rows($query) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public static function put($data) {
		$i = 0;
		while ($i <= count($data) - 1) {
			$newdata[] = $data[$i];
			$i++;
		}
		return $newdata;
	}

	public static function fetch($key) {
		$query = IB_Database::IB_Query("SELECT c_id, c_uid, c_content FROM `" . self::getTable() . "` WHERE c_uid = '{$key}' AND c_tid IS NULL");
		$rowcount = 0;
		while ($row = mysqli_fetch_array($query, MYSQLI_NUM)) {
			$i = 0;
			while ($i <= count($row) - 1) {
				if ($i === 2) {
					$z = 0;
					$data2 = json_decode($row[$i], true);
					while($z <= count($data2) - 1) {
						$content[$z] = $data2[$z];
						$z++;
					}
					$data[$rowcount][] = $content;
				} else {
					$data[$rowcount][] = $row[$i];
				}
				$i++;
			}
			$rowcount++;
		}
		if (mysqli_num_rows($query) > 0) {
			self::$cart = $data;
		} else {
			return FALSE;
		}
	}

	public static function get() {
		if (is_null(self::$cart)) {
			return FALSE;
		} else {
			self::fetch(IB_User::checkUser());
			return self::$cart;
		}
	}

	public static function getCart($data) {
		$z = 0;
		while ($z <= count($data) - 1) {
			$newdata[] = $data[$z][0] . '_' . $data[$z][1] . '_' . implode('_', $data[$z][2]);
			$z++;
		}
		$i = 0;
		while ($i <= count($newdata) - 1) {
			$cart_items[] = explode('_', $newdata[$i]);
			$i++;
		}
		return $cart_items;
	}

	public static function fetchOnly($key) {
		$id = IB_User::checkUser();
		$query = IB_Database::IB_Query("SELECT c_id, c_uid, c_content FROM `" . self::getTable() . "` WHERE c_id = '{$key}' AND c_uid = '{$id}' AND c_tid IS NULL");
		$row = mysqli_fetch_array($query, MYSQLI_NUM);
		$i = 0;
		while ($i <= count($row) - 1) {
			if ($i === 2) {
				$z = 0;
				$data2 = json_decode($row[$i], true);
				while($z <= count($data2) - 1) {
					$content[$z] = $data2[$z];
					$z++;
				}
				$data[] = $content;
			} else {
				$data[] = $row[$i];
			}
			$i++;
		}
		return $data;
	}

	public static function changedQuantity($id, $to) {
		$data = self::fetchOnly($id);
		$data[2][3] = $to;
		return $data;
	}

	public static function getTotal() {
		$results = IB_Cart::getCart(IB_Cart::get());
		$i = 0;
		$subprice = 0;
		$subqty = 0;
		$subtotal = 0;
		while ($i <= count($results) - 1) {
			$subprice += $results[$i][4];
			$subqty += $results[$i][5];
			$subtotal += $results[$i][4] * $results[$i][5];
			$i++;
		}
		$data[] = $subprice;
		$data[] = $subqty;
		$data[] = $subtotal;
		if (self::count() != 0) {
			return $data;
		} else {
			return FALSE;
		}
	}

	public static function getSubTotal() {
		return number_format(self::getTotal()[0], 2);
	}

	public static function getTotalQuantity() {
		return self::getTotal()[1];
	}

	public static function getTotalPayment() {
		if (self::count() != 0) {
			return number_format(self::getTotal()[2], 2);
		} else {
			return '0.00';
		}
	}

	public static function EmptyCart() {
		$id = IB_User::checkUser();
		$query = IB_Database::IB_Query("DELETE FROM " . self::getTable() . " WHERE c_uid = '{$id}'");
	}

	public static function getTable() {
		return self::$table;
	}
}