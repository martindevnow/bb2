<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Martin\Subscriptions\Plan;

class GenerateOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate orders for the coming week.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Searching for active plans...');

        /** @var Carbon $weekFromToday */
        $weekFromToday = Carbon::now()->addDays(7);
        $this->line('Will generate orders up to '. $weekFromToday->format('Y-m-d'));

        // First, get all plans with their latest order
        /** @var Collection $plans */
        $plans = Plan::where('active', true)->get();
        $this->line('There are '. $plans->count() . ' active plans...');

        // Check if a new order needs to be generated
        $pendingPlans = $plans->filter(function(Plan $plan) use ($weekFromToday) {
             if (! $plan->hasOrders())
                 return true;

            /** @var Carbon $nextOrderDate */
            $nextOrderDate = $plan->getNextOrderDate();
            return $nextOrderDate->lessThanOrEqualTo($weekFromToday);
        });
        $this->line('There are '. $pendingPlans->count() . ' orders to be made...');

        // Generate the orders for the plans needing one.
        $orders = [];
        foreach ($pendingPlans as $plan) {
            /** @var Plan $plan */
            $orders[] = $plan->generateOrder();
        }

        if (! $orders)
            $this->line('No orders were generated this time.');
        else
            $this->line('There were ' . count($orders) . ' orders generated.');
        $this->line('Done... Exiting');

    }
}
