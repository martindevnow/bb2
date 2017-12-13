<?php

use Illuminate\Database\Seeder;
use Martin\Vendors\Vendor;

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
        echo "Loading \"Vendors\"...\r\n";
        DB::table('vendors')->truncate();
        $this->seedFromGoogle('vendors', Vendor::class);

    }
}
