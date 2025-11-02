<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_Transaction {

    protected static $table = 'transactions_tbl';

    public static function count() { 
        $query = IB_Database::IB_Query("SELECT * FROM " . self::getTable());
        return mysqli_num_rows($query);
    }

    public static function checkPending() { 
    	$id = IB_User::checkUser();
    	$query = IB_Database::IB_Query("SELECT * FROM `" . IB_Transaction::getTable() . "` WHERE t_uid = '{$id}' AND t_status = '0'");
    	if (mysqli_num_rows($query) > 0) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }

    public static function checkRecent() { 
        $id = IB_User::checkUser();
        $query = IB_Database::IB_Query("SELECT * FROM `" . IB_Transaction::getTable() . "` WHERE t_uid = '{$id}' AND t_status = '1'");
        if (mysqli_num_rows($query) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function push($data) {
    	$id = IB_User::checkUser();
		$json_data = json_encode($data, true);
		if (self::checkPending()) {
			//
		} else {
	    	IB_Database::IB_Query("INSERT INTO `" . self::getTable() . "` (`t_uid`, `t_content`) VALUES ('{$id}', '{$json_data}')");
	    	IB_Cart::EmptyCart();
		}
    }

    public static function getTransactions() {
    	$id = IB_User::checkUser();
    	$query = IB_Database::IB_Query("SELECT * FROM `" . IB_Transaction::getTable() . "` WHERE t_uid = '{$id}' AND t_status = '0' LIMIT 1");
    	if (mysqli_num_rows($query) > 0) {
    		$row = mysqli_fetch_array($query, MYSQLI_NUM);
    		$rowcount = 0;
    		while ($rowcount <= count($row) - 1) {
    			$data[] = $row[$rowcount];
    			$rowcount++;
    		}
    		return $data;
    	} else {
    		return FALSE;
    	}
    }

    public static function getTransactionByID($id) {
        $query = IB_Database::IB_Query("SELECT * FROM `" . IB_Transaction::getTable() . "` WHERE t_id = '{$id}' LIMIT 1");
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query, MYSQLI_NUM);
            $rowcount = 0;
            while ($rowcount <= count($row) - 1) {
                $data[] = $row[$rowcount];
                $rowcount++;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    public static function getRecentTransactions() {
        $id = IB_User::checkUser();
        $query = IB_Database::IB_Query("SELECT * FROM `" . IB_Transaction::getTable() . "` WHERE t_uid = '{$id}' AND t_status = '1'");
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
            $query = IB_Database::IB_Query("SELECT * FROM " . self::getTable() . " ORDER BY t_status, created_at");
            echo '
                <div class="table_row header green">
                    <div class="cell">
                        #
                    </div>
                    <div class="cell">
                        Transaction Status
                    </div>
                    <div class="cell">
                        Transaction ID
                    </div>
                    <div class="cell">
                        Transaction Amount
                    </div>
                    <div class="cell">
                        Transaction Date
                    </div>
                    <div class="cell">
                        &nbsp;
                    </div>
                </div>
            ';
            while ($row = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                $data = json_decode($row[2], true);
                if ($row[3] == 0) {
                    $status = '<span class="ib_dashboard_status bg_blue">Pending</span>';
                    $f_btn = ' <a href="?tab=transactions&action=check&id=' . $row[0] . '"><div class="ib_table_btn bg_blue"><i class="fa fa-check"></i> &nbsp;Finish</div></a>';
                } else {
                    $status = '<span class="ib_dashboard_status bg_green">Completed</span>';
                    $f_btn = '';
                }
                echo '
                    <div class="table_row">
                        <div class="cell">
                            ' . $row[0] . '
                        </div>
                        <div class="cell">
                            ' . $status . '
                        </div>
                        <div class="cell">
                            ' . $data['transaction_summary'][0] . '
                        </div>
                        <div class="cell">
                            PHP ' . $data['transaction_summary'][1] . '
                        </div>
                        <div class="cell">
                            ' . IB_Helper::IB_OUT_DATE($data['transaction_summary'][2]) . '
                        </div>
                        <div class="cell">
                            ' . $f_btn . '
                            <a href="?tab=transactions&action=view&id=' . $row[0] . '"><div class="ib_table_btn bg_green"><i class="fa fa-eye"></i> &nbsp;View</div></a>
                            <a href="#openModal' . $row[0] .'"><div class="ib_table_btn bg_red"><i class="fa fa-times"></i> &nbsp;Delete</div></a>
                        </div>
                        ' . IB_Helper::displayDeleteModal(
                                array(
                                    'id' => $row[0],
                                    'tab' => 'transactions',
                                    'action' => 'delete',
                                    'title' => 'transaction'
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