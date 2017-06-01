<?php

use Illuminate\Database\Seeder;
use Martin\Products\Plan;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = \Martin\Products\SubPackage::all();
        $als = \Martin\Products\SubActivityLevel::all();
        $freqs = \Martin\Products\SubFrequency::all();

        foreach ($packages as $package)
        {
            foreach ($als as $al)
            {
                foreach ($freqs as $freq)
                {
                    $internalCost = \Martin\Products\Subscription::calculateInternalCost($package, $al, $freq, 5);
                    $externalCost = \Martin\Products\Subscription::calculateCost($package, $al, $freq, 5);

                    Plan::create([
                        'plan_name' => $this->getName($package, $al, $freq),
                        'subscription_package_id' => $package->id,
                        'subscription_activity_level_id' => $al->id,
                        'subscription_frequency_id' => $freq->id,
                        'internal_cost' => $internalCost,
                        'external_cost' => $externalCost,
                        'active' => true,
                    ]);
                }
            }
        }
    }

    private function getName($p, $a, $f)
    {
        return "P{$p->id}-A{$a->id}-F{$f->id}";
    }
}
