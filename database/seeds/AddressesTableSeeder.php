<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();

        for ($x = 1; $x <= 10; $x++) {
            DB::table('addresses')->insert([
                'user_id' => $x,
                'address1' => $faker->streetName,
                'address2' => $faker->streetAddress,
                'address3' => $faker->address,
                'city' => $faker->city,
                'state' => $faker->city,
                'postal_code' => $faker->postcode,
            ]);
        }
    }
}
