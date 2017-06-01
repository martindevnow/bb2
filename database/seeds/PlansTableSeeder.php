<?php

use Illuminate\Database\Seeder;
use Martin\Subscriptions\Plan;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = \Martin\Subscriptions\Package::all();
        $als = \Martin\Subscriptions\ActivityLevel::all();
        $freqs = \Martin\Subscriptions\Frequency::all();

        foreach ($packages as $package)
        {
            foreach ($als as $al)
            {
                foreach ($freqs as $freq)
                {
                    $internalCost = \Martin\Subscriptions\Subscription::calculateCost($package, $al, $freq, 5);
                    $externalCost = $internalCost * 1.5;
                    Plan::create([
                        'plan_name' => $this->getName($package, $al, $freq),
                        'package_id' => $package->id,
                        'activity_level_id' => $al->id,
                        'frequency_id' => $freq->id,
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
