<?php

use Illuminate\Database\Seeder;
use Martin\ACL\User;
use Martin\Customers\Pet;

class PetsTableSeeder extends Seeder
{
    use CanSeedFromCSV;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "Loading \"Pets\"...\r\n";
        DB::table('pets')->truncate();
        $this->seedFromGoogle('pets', Pet::class);
    }
}
