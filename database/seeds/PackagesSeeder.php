<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\ActivityLevel;
use Martin\Subscriptions\Frequency;
use Martin\Subscriptions\Package;

class PackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Package Types
         */
        Package::create([
            'label' => 'Basic',
            'code'  => 'basic',
            'lb_cost' => 2.00,
            'profit_margin' => 0.50,
            'external_lb_cost'  => (2.00 * (1 / (1 - 0.50))),
        ]);
        Package::create([
            'label' => 'Classic',
            'code'  => 'classic',
            'lb_cost' => 2.19,
            'profit_margin' => 0.50,
            'external_lb_cost'  => (2.19 * (1 / ( 1 - 0.50))),

        ]);
        Package::create([
            'label' => 'Premium',
            'code'  => 'premium',
            'lb_cost' => 2.40,
            'profit_margin' => 0.50,
            'external_lb_cost'  => (2.40 * (1 / (1 - 0.50))),

        ]);
    }
}
