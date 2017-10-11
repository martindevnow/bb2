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
    protected $signature = 'generate:orders';

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
        $leadTimeInDays = 18;

        $this->line('Searching for active plans...');

        /** @var Carbon $weekFromToday */
        $weekFromToday = Carbon::now()->addDays($leadTimeInDays);
        $this->line('Will generate orders up to '. $weekFromToday->format('Y-m-d'));

        // Check if a new order needs to be generated
        $plansNeedingNewOrders = Plan::needsOrder($leadTimeInDays)->get();
        $this->line('There are '. $plansNeedingNewOrders->count() . ' orders to be made...');

        // Generate the orders for the plans needing one.
        $orders = [];
        foreach ($plansNeedingNewOrders as $plan) {
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
