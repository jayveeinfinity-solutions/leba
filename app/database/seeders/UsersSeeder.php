<?php

class UsersSeeder
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

        echo "Seeding users...<br>";

        $users = [
            ['role_id' => 1, 'username' => 'Administrator', 'email' => 'admin@leba.com', 'password' => sha1('password123')]
        ];

        foreach ($users as $user) {
            $query = "INSERT INTO `users_tbl` (`u_rid`, `u_name`, `u_email`, `u_password`)
                      VALUES ('{$user['role_id']}', '{$user['username']}', '{$user['email']}', '{$user['password']}')";
            IB_Database::IB_Query($query);
        }
        
        IB_Database::IB_Query("INSERT INTO seeder_log (seeder_name) VALUES ('{$name}')");

        echo "✅ {$name} done!<br>";
    }
}