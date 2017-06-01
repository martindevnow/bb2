<?php

use Illuminate\Database\Seeder;
use Martin\Products\SubActivityLevel;
use Martin\Products\SubFrequency;
use Martin\Products\SubPackage;

class SubscriptionsSeeder extends Seeder
{
    use CanSeedFromCSV;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->truncate();

        $this->seedFromCSV('subscriptions', '/seeds/csv/subscriptions.csv');
    }
}
