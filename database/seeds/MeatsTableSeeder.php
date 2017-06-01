<?php

use Illuminate\Database\Seeder;
use Martin\Products\Meat;

class MeatsTableSeeder extends Seeder
{
    use CanSeedFromCSV;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('meats')->truncate();
        $this->seedFromCSV('meats', '/seeds/csv/meats.csv');

        DB::table('meat_sub_package')->truncate();
        $this->seedFromCSV('meat_sub_package', '/seeds/csv/meat_sub_package.csv');
    }
}
