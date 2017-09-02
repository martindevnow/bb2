<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\Package;

class EventItemsSeeder extends Seeder
{
    use CanSeedFromCSV;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "Loading \"EventItems\"...\r\n";
        DB::table('event_items')->truncate();
        $this->seedFromGoogle('event_items');
    }
}
