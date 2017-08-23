<?php

use Illuminate\Database\Seeder;
use Martin\Products\Meat;

class ToppingsTableSeeder extends Seeder
{
    use CanSeedFromCSV;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Loading \"Toppings\"...\r\n";
        DB::table('toppings')->truncate();
        $this->seedFromGoogle('toppings',
            \Martin\Products\Topping::class);
    }

}
