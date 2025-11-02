<?php

class IB_DBSeeder {

    public static function run() {
        echo "Running seeders...<br><br>";

        $seeders = [
            new RolesSeeder(),
            new UsersSeeder(),
            new CollectionsSeeder(),
            new ProductsSeeder(),
        ];

        foreach ($seeders as $seeder) {
            $seeder->run();
        }

        echo "<br>All seeders executed successfully!<br>";
    }
}