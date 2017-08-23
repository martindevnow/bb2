<?php

use Illuminate\Database\Seeder;
use Martin\Delivery\Courier;

class CouriersTableSeeder extends Seeder
{
    use CanSeedFromCSV;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Loading \"Couriers\"...";
        DB::table('couriers')->truncate();
        $this->seedFromGoogle('couriers', Courier::class);

    }
}
