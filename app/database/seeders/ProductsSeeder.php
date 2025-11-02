<?php

class ProductsSeeder
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

        echo "Seeding products...<br>";

        $products = [
            [
                'Jeep Wrangler Sahara',
                "As we live, our hearts turn colder.\r\nCause pain is what we go through as we become older.\r\nWe get insulted by others, lose trust for those others.\r\nWe get back stabbed by friends.\r\nIt becomes harder for us to give others a hand.",
                89535.00,
                3,
                'Jeep',
                'Jeep Wrangler Sahara'
            ],
            [
                'Mazda Rx-7',
                "The Mazda RX-7, a renowned sports car, boasts a distinctive and timeless design across its three main generations—FB, FC, and FD. Famed for its rotary engine, the RX-7 offers an exhilarating driving experience, characterized by exceptional handling and a unique engine sound. Throughout its production, the RX-7 became an icon in the sports car realm, with each generation showcasing improvements in performance and styling. The sleek and aerodynamic profile, coupled with features like pop-up headlights in earlier models, contribute to its enduring appeal. Despite its discontinuation in 2002, the RX-7 remains a symbol of Mazda's commitment to innovation and performance, leaving an indelible mark on automotive enthusiasts and car culture alike.",
                5559099.00,
                6,
                'Mazda',
                'Mazda Rx'
            ],
            [
                'Honda Civic Type RS Turbo',
                "The Honda Civic Type R, specifically the Turbo variant, is a high-performance iteration of the popular Honda Civic model. Known for its sporty and aggressive design, the Type R Turbo is a hot hatch that combines practicality with thrilling performance. Under the hood, it features a turbocharged engine that delivers impressive power, ensuring a dynamic driving experience. The Type R variant is often distinguished by its aerodynamic enhancements, bold spoilers, and iconic triple exhaust system. With a focus on precision and responsiveness, the Civic Type R Turbo offers sharp handling and a sport-tuned suspension for enthusiasts seeking an engaging ride. Inside, it may feature sporty and supportive seats, along with advanced technology and connectivity options. As a testament to its performance capabilities, the Honda Civic Type R Turbo has gained a reputation as a standout in the hot hatch segment, appealing to drivers who appreciate a perfect blend of speed and practicality.",
                2112500.00,
                2,
                'Honda',
                'Honda Civic Type RS Turbo'
            ],
            [
                'Nissan GTR 2023',
                "The Nissan GTR, often referred to as the 'Godzilla,' is a high-performance sports car that has garnered a reputation for its impressive speed, handling, and technological features. The GTR is known for its powerful twin-turbocharged engine, advanced all-wheel-drive system, and aerodynamic design. Performance enthusiasts are drawn to the GTR for its quick acceleration, precise handling, and cutting-edge technology that enhances both driving experience and safety.",
                2029000.00,
                6,
                'Nissan',
                'Nissan GTR 2023'
            ],
            [
                'Toyota Supra',
                "The Toyota Supra, an iconic sports car, is celebrated for its dynamic performance and sleek design. It typically features a powerful turbocharged engine, offering exhilarating acceleration and precise handling. With its aerodynamic design and driver-focused cockpit, the Supra remains a thrilling and well-rounded sports car appealing to enthusiasts who value both speed and style.",
                6500500.00,
                6,
                'Toyota',
                'Toyota Supra'
            ]
        ];

        foreach ($products as $p) {
            $query = "
                INSERT INTO `products_tbl`
                (`p_label`, `p_description`, `p_price`, `p_colid`, `p_category`, `p_color_scheme`)
                VALUES (
                    '" . addslashes($p[0]) . "',
                    '" . addslashes($p[1]) . "',
                    {$p[2]},
                    {$p[3]},
                    '" . addslashes($p[4]) . "',
                    '" . addslashes($p[5]) . "'
                )
            ";
            IB_Database::IB_Query($query);
        }

        IB_Database::IB_Query("INSERT INTO seeder_log (seeder_name) VALUES ('{$name}')");

        echo "✅ {$name} done!<br>";
    }
}
