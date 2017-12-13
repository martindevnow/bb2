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
        echo "Loading \"Meals\"...\r\n";
        DB::table('meals')->truncate();
        $this->seedFromGoogle('meals', \Martin\Products\Meal::class);

        DB::table('meal_meat')->truncate();
        $this->seedFromGoogle('meal_meat');

        DB::table('meal_topping')->truncate();
        $this->seedFromGoogle('meal_topping');
    }
}
