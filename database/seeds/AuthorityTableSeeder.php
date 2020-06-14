<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorityTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('authorities')->insert([
            'name' => 'ADMIN',
        ]);
        DB::table('authorities')->insert([
            'name' => 'CUSTOMER',
        ]);
        DB::table('authorities')->insert([
            'name' => 'AGENT',
        ]);
    }
}
