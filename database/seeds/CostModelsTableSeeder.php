<?php

use Illuminate\Database\Seeder;
use Martin\ACL\User;
use Martin\Customers\Pet;

class CostModelsTableSeeder extends Seeder
{
    use CanSeedFromCSV;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        echo "Loading \"Cost Models\"...\r\n";
        DB::table('cost_models')->truncate();
        $this->seedFromGoogle('cost_models', \Martin\Subscriptions\CostModel::class);
    }
}
