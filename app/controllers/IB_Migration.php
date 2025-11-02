<?php

class IB_Migration
{
    public static function run()
    {
        echo "🚀 Running database migrations...<br>";

        // 1. cart_tbl
        IB_Database::IB_Query("
            CREATE TABLE IF NOT EXISTS `cart_tbl` (
              `c_id` int NOT NULL AUTO_INCREMENT,
              `c_uid` int NOT NULL,
              `c_content` longtext NOT NULL,
              `c_tid` int DEFAULT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`c_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        // 2. collections_tbl
        IB_Database::IB_Query("
            CREATE TABLE IF NOT EXISTS `collections_tbl` (
              `col_id` int NOT NULL AUTO_INCREMENT,
              `col_label` varchar(50) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`col_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        // 3. products_tbl
        IB_Database::IB_Query("
            CREATE TABLE IF NOT EXISTS `products_tbl` (
              `p_id` int NOT NULL AUTO_INCREMENT,
              `p_label` varchar(30) NOT NULL,
              `p_description` longtext NOT NULL,
              `p_price` decimal(10,2) NOT NULL,
              `p_colid` int NOT NULL,
              `p_category` varchar(30) DEFAULT NULL,
              `p_color_scheme` varchar(30) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`p_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        // 4. roles_tbl
        IB_Database::IB_Query("
            CREATE TABLE IF NOT EXISTS `roles_tbl` (
              `r_id` int NOT NULL AUTO_INCREMENT,
              `r_label` varchar(50) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`r_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        // 5. seeder_log
        IB_Database::IB_Query("
            CREATE TABLE IF NOT EXISTS `seeder_log` (
              `seeder_name` varchar(255) NOT NULL,
              `run_at` datetime DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`seeder_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        ");

        // 6. transactions_tbl
        IB_Database::IB_Query("
            CREATE TABLE IF NOT EXISTS `transactions_tbl` (
              `t_id` int NOT NULL AUTO_INCREMENT,
              `t_uid` int NOT NULL,
              `t_content` longtext NOT NULL,
              `t_status` set('0','1') NOT NULL DEFAULT '0',
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`t_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        // 7. users_tbl
        IB_Database::IB_Query("
            CREATE TABLE IF NOT EXISTS `users_tbl` (
              `u_id` int NOT NULL AUTO_INCREMENT,
              `u_rid` int NOT NULL DEFAULT '2',
              `u_name` varchar(20) NOT NULL,
              `u_email` varchar(50) NOT NULL,
              `u_avatar` text,
              `u_password` varchar(40) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`u_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        // 8. user_informations_tbl
        IB_Database::IB_Query("
            CREATE TABLE IF NOT EXISTS `user_informations_tbl` (
              `ui_id` int NOT NULL AUTO_INCREMENT,
              `ui_uid` int NOT NULL,
              `ui_first` varchar(50) NOT NULL,
              `ui_middle` varchar(30) DEFAULT NULL,
              `ui_last` varchar(30) NOT NULL,
              `ui_address` varchar(255) NOT NULL,
              `ui_contact` varchar(11) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`ui_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        ");

        echo "✅ All tables migrated successfully!<br>";
    }
}
