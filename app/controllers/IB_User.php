<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_User {

    protected static $table = 'users_tbl';

    public static function count() { 
        $query = IB_Database::IB_Query("SELECT * FROM " . self::getTable());
        return mysqli_num_rows($query);
    }

	public static function checkUser() {
        $query = IB_Database::IB_Query("SELECT u_id FROM `" . self::getTable() . "` WHERE u_id = '{$_SESSION['authtoken']}'");
        $row = mysqli_fetch_array($query, MYSQLI_BOTH);
        return $row['u_id'];
    }

    public static function getUser($key = null) {
    	if (is_null($key)) {
    		$keyid = self::checkUser();
    	} else {
    		$keyid = $key;
    	}
		$query = IB_Database::IB_Query("SELECT * FROM `" . self::getTable() . "` WHERE u_id = '$keyid'");
		$row = mysqli_fetch_array($query, MYSQLI_NUM);
		$i = 0;
		while ($i <= count($row) - 1) {
			$data[] = $row[$i];
			$i++;
		}
		$hash = '';
		foreach ($data as $key => $value) {
			if ($key === 4 || $key === 6 || $key === 7) {
				//
			} else {
				$hash .= $value;
			}
		}
		$data[] = md5($hash);
		return $data;
	}

    public static function getUserData($key, $id = null) {
    	if (is_null($id)) {
    		$id = self::checkUser();
    	} else {
    		$id = $id;
    	}
    	$results = self::getUser($id);
        if ($key === 'ID') {
            return $results[0];
        } elseif ($key === 'RID') {
            return $results[1];
        } elseif ($key === 'UN') {
            return $results[2];
        } elseif ($key === 'EM') {
            return $results[3];
        } elseif ($key === 'AV') {
            return $results[4];
        } elseif ($key === 'PWD') {
            return $results[5];
        } elseif ($key === 'CD') {
            return $results[6];
        } elseif ($key === 'UD') {
            return $results[7];
        } elseif ($key === 'HASH') {
            return $results[8];
        } else {
            return FALSE;
        }
    }

    public static function getUserPassword() {
        $keyid = self::checkUser();
        $query = IB_Database::IB_Query("SELECT u_password FROM `" . self::getTable() . "` WHERE u_id = '$keyid'");
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query, MYSQLI_NUM);
            return $row[0];
        } else {
            return FALSE;
        }
    }

    public static function findIfExists($data) {
        if ($data[0] === 'Username') {
            $field = 'u_name';
            $param = $data[1];
        } else {
            $field = 'u_email';
            $param = $data[1];
        }
        $id = self::checkUser();
        $query = IB_Database::IB_Query("SELECT " . $field . " FROM `" . self::getTable() . "` WHERE " . $field . " = '{$param}' AND u_id != '{$id}'");
        if (mysqli_num_rows($query) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function getAllUsersID() {
        $query = IB_Database::IB_Query("SELECT u_id FROM " . self::getTable());
        $data = array();
        while ($row = mysqli_fetch_array($query, MYSQLI_NUM)) {
            $data[] = $row[0];
        }
        return $data;
    }

    public static function checkTable() {
        $query = IB_Database::IB_Query("SELECT * FROM `" . self::getTable() . "`");
        if (mysqli_num_rows($query) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public static function viewTable() {
        if (self::checkTable()) {
            $query = IB_Database::IB_Query("SELECT * FROM " . self::getTable());
            echo '
                <div class="table_row header green">
                    <div class="cell">
                        #
                    </div>
                    <div class="cell">
                        User Role
                    </div>
                    <div class="cell">
                        Username
                    </div>
                    <div class="cell">
                        Email
                    </div>
                    <div class="cell">
                        Created At
                    </div>
                    <div class="cell">
                        Updated At
                    </div>
                    <div class="cell">
                        &nbsp;
                    </div>
                </div>
            ';
            while ($row = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                echo '
                    <div class="table_row">
                        <div class="cell">
                            ' . $row[0] . '
                        </div>
                        <div class="cell">
                            ' . IB_Role::getRoleByLabel($row[1]) . '
                        </div>
                        <div class="cell">
                            ' . $row[2] . '
                        </div>
                        <div class="cell">
                            ' . $row[3] . '
                        </div>
                        <div class="cell">
                            ' . IB_Helper::IB_OUT_DATE($row[6]) . '
                        </div>
                        <div class="cell">
                            ' . IB_Helper::IB_OUT_DATE($row[7]) . '
                        </div>
                        <div class="cell">
                            <a href="?tab=users&action=view&id=' . $row[0] . '"><div class="ib_table_btn bg_green"><i class="fa fa-eye"></i> &nbsp;View</div></a>
                            <a href="?tab=users&action=edit&id=' . $row[0] . '"><div class="ib_table_btn bg_blue"><i class="fa fa-pencil"></i> &nbsp;Edit</div></a>
                            <a href="#openModal' . $row[0] .'"><div class="ib_table_btn bg_red"><i class="fa fa-times"></i> &nbsp;Delete</div></a>
                        </div>
                        ' . IB_Helper::displayDeleteModal(
                                array(
                                    'id' => $row[0],
                                    'tab' => 'users',
                                    'action' => 'delete',
                                    'title' => 'user'
                                )
                            ) . '
                    </div>
                ';
            }
        } else {
            echo '
                <div class="ib_dashboard_info_message bg_green">
                    There are no collections!<br>
                    <span>To add a collection, click <a href="?tab=collections&action=create">Add collection</a></span>
                </div>
            ';
        }
    }

    public static function getTable() {
        return self::$table;
    }
}