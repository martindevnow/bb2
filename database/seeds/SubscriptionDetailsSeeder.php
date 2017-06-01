<?php

use Illuminate\Database\Seeder;
use Martin\Products\SubActivityLevel;
use Martin\Products\SubFrequency;
use Martin\Products\SubPackage;

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
        SubPackage::create([
            'label' => 'Basic',
            'code'  => 'basic',
            'lb_cost' => 2.00,
            'profit_margin' => 0.50,
            'external_lb_cost'  => (2.00 * (1 / (1 - 0.50))),
        ]);
        SubPackage::create([
            'label' => 'Classic',
            'code'  => 'classic',
            'lb_cost' => 2.19,
            'profit_margin' => 0.50,
            'external_lb_cost'  => (2.19 * (1 / ( 1 - 0.50))),

        ]);
        SubPackage::create([
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
        SubActivityLevel::create([
            'label' => 'Low',
            'code'  => 'low',
            'multiplier' => 0.020,
        ]);
        SubActivityLevel::create([
            'label' => 'Medium',
            'code'  => 'medium',
            'multiplier' => 0.025,
        ]);
        SubActivityLevel::create([
            'label' => 'High',
            'code'  => 'high',
            'multiplier' => 0.030,
        ]);

        /**
         * Delivery Frequencies
         */
        SubFrequency::create([
            'label' => 'Weekly',
            'code'  => 'weekly',
            'multiplier'        => 1,
            'discount_percent'  => 0,
        ]);
        SubFrequency::create([
            'label' => 'Bi-Weekly',
            'code'  => 'biweekly',
            'multiplier'        => 2,
            'discount_percent'  => 0.04,
        ]);
        SubFrequency::create([
            'label' => 'Monthly',
            'code'  => 'monthly',
            'multiplier'        => 4,
            'discount_percent'  => 0.05,
        ]);

        
        
    }
}
