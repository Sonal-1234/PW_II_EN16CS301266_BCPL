<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();
        DB::table('organizations')->insert([
            'name' => $faker->company,
            'email' => $faker->email,
            'logo' => asset('logo.png'),
            'owner_name' => $faker->name,
            'organization_code' => $faker->swiftBicNumber,
            'pan_no' => "GEHSH4785A",
            'gstin_no' => $faker->macAddress,
            'is_default' => 1,
            'registration_no' => $faker->creditCardNumber,
        ]);
    }
}
