<?php

class IB_DBSeeder {

    public static function run() {
        echo "Running seeders...<br><br>";

        (new RolesSeeder())->run();
        (new UsersSeeder())->run();

        echo "<br>All seeders executed successfully!<br>";
    }
}