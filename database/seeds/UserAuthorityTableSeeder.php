<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAuthorityTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('user_authorities')->insert([
            'user_id' => 1,
            'authority_name' => 'ADMIN',
        ]);

        for ($x = 2; $x <= 5; $x++) :
            DB::table('user_authorities')->insert([
                'user_id' => $x,
                'authority_name' => 'AGENT',
            ]);
        endfor;

        for ($x = 6; $x <= 10; $x++) :
            DB::table('user_authorities')->insert([
                'user_id' => $x,
                'authority_name' => 'CUSTOMER',
            ]);
        endfor;
    }
}
