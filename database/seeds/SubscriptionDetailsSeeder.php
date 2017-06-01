<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\ActivityLevel;
use Martin\Subscriptions\Frequency;
use Martin\Subscriptions\Package;

class SubscriptionDetailsSeeder extends Seeder
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

        //profit = (selling price - cost) / selling_price
        /**
         * Activity Levels
         */
        ActivityLevel::create([
            'label' => 'Low',
            'code'  => 'low',
            'multiplier' => 0.020,
        ]);
        ActivityLevel::create([
            'label' => 'Medium',
            'code'  => 'medium',
            'multiplier' => 0.025,
        ]);
        ActivityLevel::create([
            'label' => 'High',
            'code'  => 'high',
            'multiplier' => 0.030,
        ]);

        /**
         * Delivery Frequencies
         */
        Frequency::create([
            'label' => 'Weekly',
            'code'  => 'weekly',
            'multiplier'        => 1,
            'discount_percent'  => 0,
        ]);
        Frequency::create([
            'label' => 'Bi-Weekly',
            'code'  => 'biweekly',
            'multiplier'        => 2,
            'discount_percent'  => 0.00,
        ]);
        Frequency::create([
            'label' => 'Monthly',
            'code'  => 'monthly',
            'multiplier'        => 4,
            'discount_percent'  => 0.00,
        ]);

        
        
    }
}
