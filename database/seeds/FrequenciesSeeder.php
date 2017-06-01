<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\ActivityLevel;
use Martin\Subscriptions\Frequency;
use Martin\Subscriptions\Package;

class FrequenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
