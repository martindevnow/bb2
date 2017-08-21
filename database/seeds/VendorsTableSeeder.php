<?php

use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    use CanSeedFromCSV;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vendors')->truncate();

        $this->seedFromCSV('vendors', '/seeds/csv/vendors.csv', \Martin\Vendors\Vendor::class);

    }
}
