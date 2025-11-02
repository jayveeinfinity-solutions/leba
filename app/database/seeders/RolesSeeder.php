<?php

class RolesSeeder
{
    public function run()
    {
        $name = __CLASS__;

        $result = IB_Database::IB_Query("SELECT COUNT(*) as count FROM `seeder_log` WHERE `seeder_name` = '{$name}'");
        $row = $result->fetch_assoc();

        if ($row && $row['count'] > 0) {
            echo "⚠️  Skipping {$name} (already executed)<br>";
            return;
        }

        echo "Seeding roles...<br>";

        $roles = [
            'Administrator', 'Normal User'
        ];

        foreach ($roles as $role) {
            $query = "INSERT INTO `roles_tbl` (`r_label`)
                      VALUES ('{$role}')";

            IB_Database::IB_Query($query);
        }
        
        IB_Database::IB_Query("INSERT INTO seeder_log (seeder_name) VALUES ('{$name}')");

        echo "✅ {$name} done!<br>";
    }
}