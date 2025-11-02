<?php

class IB_Database {
 	private static $_instance = null;
 	private static $ib_conx;

 	 public static function IB_Connect() {    
        // Try and connect to the database
        if(!isset(self::$ib_conx)) {
            // Load configuration as an array. Use the actual location of your configuration file
            self::$ib_conx = new mysqli(IB_Config::get('mysql/host'), IB_Config::get('mysql/username'), IB_Config::get('mysql/password'), IB_Config::get('mysql/database'));
        }

        // If connection was not successful, handle the error
        if(self::$ib_conx === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return false;
        }
        return self::$ib_conx;
    }

	public static function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new IB_Database();
		}
		return self::$_instance;
	}

    public static function IB_Query($query) {
        $ib_conx = self::IB_Connect();
        $getQueryData = mysqli_query($ib_conx, $query);
        return $getQueryData;
    }

    public static function IB_Escape($IB_POST_STR) {
        $ib_conx = self::IB_Connect();
        $getEscapeData = strip_tags(mysqli_real_escape_string($ib_conx, $IB_POST_STR));
        return $getEscapeData;
    }
}