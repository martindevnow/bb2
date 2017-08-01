<?php

use Illuminate\Database\Seeder;


class AddressesTableSeeder extends Seeder
{
    use CanSeedFromCSV;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "Loading \"Addresses\"...\r\n";
        DB::table('addresses')->truncate();
        $this->seedFromGoogle('addresses', \Martin\Core\Address::class);
    }
}
