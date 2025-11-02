<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_Role {

    protected static $table = 'roles_tbl';

    public static function getRoleByLabel($role_id) {
    	switch ($role_id) {
    		case 1:
    			return 'Administrator';
    			break;
    		
    		case 2:
    			return 'Normal User';
    			break;
    		
    		default:
    			return FALSE;
    			break;
    	}
    }

    public static function getRoles($order = null) {
        $query = IB_Database::IB_Query("SELECT * FROM `" . self::getTable() . "` " . $order);
        if (mysqli_num_rows($query) > 0) {
            $rowcount = 0;
            while($row = mysqli_fetch_array($query, MYSQLI_NUM)) {
                $i = 0;
                while ($i <= count($row) - 1) {
                    $data[$rowcount][] = $row[$i];
                    $i++;
                }
                $rowcount++;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    public static function checkRoleIfAdmin($role_id) {
    	if (self::getRoleByLabel($role_id) == 'Administrator') {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }

    public static function getAllRolesID() {
        $query = IB_Database::IB_Query("SELECT r_id FROM " . self::getTable());
        $data = array();
        while ($row = mysqli_fetch_array($query, MYSQLI_NUM)) {
            $data[] = $row[0];
        }
        return $data;
    }

    public static function findRole($id) {
        $query = IB_Database::IB_Query("SELECT * FROM " . self::getTable() ." WHERE r_id = '{$id}'");
        if (mysqli_num_rows($query) > 0) {
            $rowcount = 0;
            while($row = mysqli_fetch_array($query, MYSQLI_NUM)) {
                $i = 0;
                while ($i <= count($row) - 1) {
                    $data[$rowcount][] = $row[$i];
                    $i++;
                }
                $rowcount++;
            }
            return $data;
        } else {
            return FALSE;
        }
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
                        Role Label
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
                            ' . $row[1] . '
                        </div>
                        <div class="cell">
                            ' . IB_Helper::IB_OUT_DATE($row[2]) . '
                        </div>
                        <div class="cell">
                            ' . IB_Helper::IB_OUT_DATE($row[3]) . '
                        </div>
                        <div class="cell">
                            <a href="?tab=roles&action=edit&id=' . $row[0] . '"><div class="ib_table_btn bg_blue"><i class="fa fa-pencil"></i> &nbsp;Edit</div></a>
                            <a href="#openModal' . $row[0] .'"><div class="ib_table_btn bg_red"><i class="fa fa-times"></i> &nbsp;Delete</div></a>
                        </div>
                        ' . IB_Helper::displayDeleteModal(
                                array(
                                    'id' => $row[0],
                                    'tab' => 'roles',
                                    'action' => 'delete',
                                    'title' => 'role'
                                )
                            ) . '
                    </div>
                ';
            }
        } else {
            echo '
                <div class="ib_dashboard_info_message bg_green">
                    There are no roles!<br>
                    <span>To add a role, click <a href="?tab=roles&action=create">Add role</a></span>
                </div>
            ';
        }
    }

    public static function getTable() {
        return self::$table;
    }
}