<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_UserInfo {

    protected static $table = 'user_informations_tbl';

	public static function checkUserInfo() {
        $keyid = IB_User::checkUser();
        $query = IB_Database::IB_Query("SELECT ui_uid FROM `" . self::getTable() . "` WHERE ui_uid = '{$keyid}'");
        if (mysqli_num_rows($query) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function getInfo($key = null) {
    	if (is_null($key)) {
    		$keyid = IB_User::checkUser();
    	} else {
    		$keyid = $key;
    	}
		$query = IB_Database::IB_Query("SELECT * FROM `" . self::getTable() . "` WHERE ui_uid = '$keyid'");
		$row = mysqli_fetch_array($query, MYSQLI_NUM);
		$i = 0;
		while ($i <= count($row) - 1) {
			$data[] = $row[$i];
			$i++;
		}
		$hash = '';
		foreach ($data as $key => $value) {
			if ($key === 7 || $key === 8) {
				// 
			} else {
				$hash .= $value;
			}
		}
		$data[] = md5($hash);
		return $data;
	}

    public static function getUserInfo($key, $id = null) {
    	if (is_null($id)) {
    		$id = IB_User::checkUser();
    	} else {
    		$id = $id;
    	}
        if (self::checkUserInfo()) {
            $results = self::getInfo($id);
            if ($key === 'ID') {
                return $results[0];
            } elseif ($key === 'FN') {
                return $results[2];
            } elseif ($key === 'MN') {
                return $results[3];
            } elseif ($key === 'LN') {
                return $results[4];
            } elseif ($key === 'AD') {
                return $results[5];
            } elseif ($key === 'CN') {
                return $results[6];
            } elseif ($key === 'HASH') {
                return $results[7];
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public static function getTable() {
        return self::$table;
    }
}