<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_Collection {

	protected static $table = 'collections_tbl';

	public static function getCollections($order = null) {
		$query = IB_Database::IB_Query("SELECT `col_id`, `col_label` FROM `" . self::getTable() . "` " . $order);
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

	public static function getCollectionsID() {
		$query = IB_Database::IB_Query("SELECT `col_id` FROM `" . self::getTable() . "`");
		if (mysqli_num_rows($query) > 0) {
			$rowcount = 0;
			while($row = mysqli_fetch_array($query, MYSQLI_NUM)) {
				$i = 0;
				while ($i <= count($row) - 1) {
					$data[$rowcount] = $row[$i];
					$i++;
				}
				$rowcount++;
			}
			return $data;
		} else {
			return FALSE;
		}
	}

	public static function getCollectionID($id) {
		$query = IB_Database::IB_Query("SELECT `col_id` FROM `" . self::getTable() . "` WHERE col_id = '{$id}'");
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query, MYSQLI_NUM);
			$i = 0;
			while ($i <= count($row) - 1) {
				$data[] = $row[$i];
				$i++;
			}
			return $data;
		} else {
			return FALSE;
		}
	}

	public static function getCollectionLabel($id) {
		$query = IB_Database::IB_Query("SELECT `col_label` FROM `" . self::getTable() . "` WHERE col_id = '{$id}'");
		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_array($query, MYSQLI_NUM);
			$i = 0;
			while ($i <= count($row) - 1) {
				$data[] = $row[$i];
				$i++;
			}
			return $data;
		} else {
			return FALSE;
		}
	}

    public static function getAllCollectionsID() {
        $query = IB_Database::IB_Query("SELECT col_id FROM " . self::getTable());
        $data = array();
        while ($row = mysqli_fetch_array($query, MYSQLI_NUM)) {
            $data[] = $row[0];
        }
        return $data;
    }

    public static function findCollection($id) {
        $query = IB_Database::IB_Query("SELECT * FROM " . self::getTable() ." WHERE col_id = '{$id}'");
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
				    	Vehicle Type
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
							<a href="?tab=collections&action=edit&id=' . $row[0] . '"><div class="ib_table_btn bg_blue"><i class="fa fa-pencil"></i> &nbsp;Edit</div></a>
							<a href="#openModal' . $row[0] .'"><div class="ib_table_btn bg_red"><i class="fa fa-times"></i> &nbsp;Delete</div></a>
						</div>
						' . IB_Helper::displayDeleteModal(
								array(
									'id' => $row[0],
									'tab' => 'collections',
									'action' => 'delete',
									'title' => 'collection'
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