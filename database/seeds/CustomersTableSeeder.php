<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();
        for ($x = 6; $x <= 10; $x++) {
            $customerId = DB::table('customers')->insertGetId([
                'user_id' => $x,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone1' => 9893694008,
                'email' => $faker->email,
            ]);

            for ($y = 1; $y < 3; $y++) {
                DB::table('customer_accounts')->insert([
                    'customer_id' => $customerId,
                    'account_no' => rand(1111111111, 999999999),
                    'description' => 'What made you want to look',
                    'status' => 'ACTIVE'
                ]);
            }

            DB::table('customer_companies')->insert([
                'customer_id' => $customerId,
                'name' => $faker->company,
                'contact_number' => $faker->creditCardNumber,
                'contact_person' => $faker->name,
                'gst_number' => 'GST' . $faker->macAddress
            ]);

            DB::table('addresses')->insert([
                'user_id' => $x,
                'type' => 'BILLING',
                'phone1' => $faker->creditCardNumber,
                'address1' => $faker->address,
                'address2' => $faker->address,
                'postal_code' => $faker->postcode,
                'city' => $faker->city,
                'state' => 'MP',
            ]);

            DB::table('addresses')->insert([
                'user_id' => $x,
                'type' => 'INSTALLATION',
                'phone1' => $faker->creditCardNumber,
                'address1' => $faker->address,
                'address2' => $faker->address,
                'postal_code' => $faker->postcode,
                'city' => $faker->city,
                'state' => 'MP',
            ]);
        }
    }
}
