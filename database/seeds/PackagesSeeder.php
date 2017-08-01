<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\Package;

class PackagesSeeder extends Seeder
{
    use CanSeedFromCSV;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "Loading \"Packages\"...\r\n";
        DB::table('packages')->truncate();
        $this->seedFromGoogle('packages', Package::class);

        echo "Loading \"Meal Packages\"...\r\n";
        DB::table('meal_package')->truncate();
        $this->seedFromGoogle('meal_package');
    }
}
