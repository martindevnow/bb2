<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\ActivityLevel;
use Martin\Subscriptions\Frequency;
use Martin\Subscriptions\Package;

class ActivityLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
