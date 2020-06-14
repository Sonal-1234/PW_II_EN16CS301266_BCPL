<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();

        $product = [];
        for ($x = 1; $x <= 9; $x++) :
            $product = [
                [
                    'name' => 'TP-Link Mini Pocket 3G/4G Wireless Router',
                    'sac_code' => 'ACD-3020',
                    'description' => $faker->paragraph,
                    'price' => '1150',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'ONE_TIME_COST_PRODUCT',
                ], [
                    'name' => 'iBall Baton Smart Dual Band Wireless AC Router (Black)',
                    'sac_code' => 'ACD-iB-WRD12EN',
                    'description' => $faker->paragraph,
                    'price' => '1650',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'ONE_TIME_COST_PRODUCT',
                ], [
                    'name' => 'D-Link DIR-615 Wireless-N300 Router',
                    'sac_code' => 'ACD-DIR-615',
                    'description' => $faker->paragraph,
                    'price' => '2050',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'ONE_TIME_COST_PRODUCT',
                ], [
                    'name' => '500 GB Data with 15 Mbps, thereafter Unlimited with speed upto 3 Mbps',
                    'sac_code' => 'ACD' . rand(100, 999),
                    'description' => $faker->paragraph,
                    'price' => '2500',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'SERVICE_BASE_PRODUCT',
                ], [
                    'name' => '500 GB Data with 25 Mbps, thereafter Unlimited with speed upto 3 Mbps',
                    'sac_code' => 'ACD' . rand(100, 999),
                    'description' => $faker->paragraph,
                    'price' => '3000',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'SERVICE_BASE_PRODUCT',
                ], [
                    'name' => '500 GB Data with 40 Mbps, thereafter Unlimited with speed upto 5 Mbps',
                    'sac_code' => 'ACD' . rand(100, 999),
                    'description' => $faker->paragraph,
                    'price' => '4500',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'SERVICE_BASE_PRODUCT',
                ], [
                    'name' => '500 GB Data with 50 Mbps, thereafter Unlimited with speed upto 5 Mbps',
                    'sac_code' => 'ACD' . rand(100, 999),
                    'description' => $faker->paragraph,
                    'price' => '5500',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'SERVICE_BASE_PRODUCT',
                ], [
                    'name' => '500 GB Data with 60 Mbps, thereafter Unlimited with speed upto 5 Mbps',
                    'sac_code' => 'ACD' . rand(100, 999),
                    'description' => $faker->paragraph,
                    'price' => '6500',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'SERVICE_BASE_PRODUCT',
                ], [
                    'name' => '1000 GB Data with 10 Mbps, thereafter Unlimited with speed upto 5 Mbps',
                    'sac_code' => 'ACD' . rand(100, 999),
                    'description' => $faker->paragraph,
                    'price' => '7500',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'SERVICE_BASE_PRODUCT',
                ], [
                    'name' => '1000 GB Data with 15 Mbps, thereafter Unlimited with speed upto 5 Mbps',
                    'sac_code' => 'ACD' . rand(100, 999),
                    'description' => $faker->paragraph,
                    'price' => '8500',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'SERVICE_BASE_PRODUCT',
                ], [
                    'name' => '1000 GB Data with 25 Mbps, thereafter Unlimited with speed upto 5 Mbps',
                    'sac_code' => 'ACD' . rand(100, 999),
                    'description' => $faker->paragraph,
                    'price' => '9500',
                    'cgst' => 9,
                    'sgst' => 9,
                    'igst' => 18,
                    'type' => 'SERVICE_BASE_PRODUCT',
                ],
            ];
        endfor;

        DB::table('products')->insert($product);
    }
}
