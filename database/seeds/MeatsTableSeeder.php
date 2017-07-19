<?php

use Illuminate\Database\Seeder;

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
        $this->seedFromGoogle('meats', \Martin\Products\Meat::class);

//        DB::table('meat_package')->truncate();
//        $this->seedFromCSV('meat_package', '/seeds/csv/meat_package.csv');
    }
}
