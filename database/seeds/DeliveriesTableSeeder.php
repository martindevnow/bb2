<?php

use Illuminate\Database\Seeder;
use Martin\Products\Meat;

class DeliveriesTableSeeder extends Seeder
{
    use CanSeedFromCSV;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Loading \"Deliveries\"...\r\n";
        DB::table('deliveries')->truncate();
        $this->seedFromCSV('deliveries', '/seeds/csv/deliveries.csv', \Martin\Delivery\Delivery::class);
    }
}
