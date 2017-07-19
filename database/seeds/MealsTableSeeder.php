<?php

use Illuminate\Database\Seeder;
use Martin\Products\Meat;

class MealsTableSeeder extends Seeder
{
    use CanSeedFromCSV;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('meals')->truncate();
        $this->seedFromGoogle('meals', \Martin\Products\Meal::class);

//        DB::table('meal_package')->truncate();
//        $this->seedFromCSV('meal_package', '/seeds/csv/meal_package.csv');
    }
}
