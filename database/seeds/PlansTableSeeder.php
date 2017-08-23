<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\Plan;

class PlansTableSeeder extends Seeder
{
    use CanSeedFromCSV;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "Loading \"Plans\"...\r\n";
        DB::table('plans')->truncate();
        $this->seedFromGoogle('plans', Plan::class);
    }
}
