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
    public function run()
    {
        DB::table('pets')->truncate();

        $this->seedFromCSV('pets',
            '/seeds/csv/pets.csv',
            Pet::class);

    }
}
