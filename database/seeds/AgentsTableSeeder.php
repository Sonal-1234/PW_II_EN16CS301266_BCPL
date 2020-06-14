<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();

        for ($x = 2; $x <= 5; $x++) :
            DB::table('agents')->insert([
                'user_id' => $x,
                'name' => $faker->firstName,
                'phone1' => rand(111111111, 999999999),
                'email' => $faker->email,
            ]);
        endfor;
    }
}
