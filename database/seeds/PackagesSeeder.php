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

        /**
         * Basic -- And Variations
         */
        Package::create([
            'label' => 'Basic',
            'code'  => 'basic',
            'profit_margin' => 0.50,
        ]);
        Package::create([
            'label' => 'Basic (No Chicken)',
            'code'  => 'basic-no-chicken',
            'profit_margin' => 0.50,
            'public'=> false,

        ]);

        /**
         * Classic -- And Variations
         */
        Package::create([
            'label' => 'Classic',
            'code'  => 'classic',
            'profit_margin' => 0.50,
        ]);
        Package::create([
            'label' => 'Classic (No Chicken)',
            'code'  => 'classic-no-chicken',
            'profit_margin' => 0.50,
            'public'=> false,
        ]);
        Package::create([
            'label' => 'Classic (No Poultry)',
            'code'  => 'classic-no-poultry',
            'profit_margin' => 0.50,
            'public'=> false,
        ]);
        Package::create([
            'label' => 'Classic (No Fish)',
            'code'  => 'classic-no-fish',
            'profit_margin' => 0.50,
            'public'=> false,
        ]);
        Package::create([
            'label' => 'Classic (No Pork)',
            'code'  => 'classic-no-pork',
            'profit_margin' => 0.50,
            'public'=> false,
        ]);
        Package::create([
            'label' => 'Classic (Whole Prey)',
            'code'  => 'classic-whole-prey',
            'profit_margin' => 0.50,
            'public'=> false,
        ]);


        Package::create([
            'label' => 'Premium',
            'code'  => 'premium',
            'profit_margin' => 0.50,
        ]);
    }
}
