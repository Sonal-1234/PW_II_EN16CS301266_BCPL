<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call([     
            UsersTableSeeder  ::class,
            AuthorityTableSeeder::class,
            UserAuthorityTableSeeder::class,
            #OrganizationsTableSeeder::class,
            #AddressesTableSeeder::class,
            #ProductTableSeeder::class,
            #CustomersTableSeeder::class,
            #AgentsTableSeeder::class,
        ]);
    }
}
