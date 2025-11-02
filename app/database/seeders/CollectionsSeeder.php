<?php

class CollectionsSeeder
{
    public static function run()
    {
        $name = __CLASS__;

        $result = IB_Database::IB_Query("SELECT COUNT(*) as count FROM `seeder_log` WHERE `seeder_name` = '{$name}'");
        $row = $result->fetch_assoc();

        if ($row && $row['count'] > 0) {
            echo "⚠️  Skipping {$name} (already executed)<br>";
            return;
        }

        echo "Seeding collections...<br>";

        $collections = [
            ['Hatchback'],
            ['Sedan'],
            ['SUV'],
            ['Coupe'],
            ['Convertible'],
            ['Sports Car'],
            ['Electric'],
            ['Hybrid'],
        ];

        foreach ($collections as $col) {
            $query = "INSERT INTO `collections_tbl` (`col_label`) VALUES ('{$col[0]}')";
            IB_Database::IB_Query($query);
        }

        IB_Database::IB_Query("INSERT INTO seeder_log (seeder_name) VALUES ('{$name}')");

        echo "✅ {$name} done!<br>";
    }
}
