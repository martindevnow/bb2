<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Martin\Subscriptions\Plan;

class AssociateAddressesToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'associate:addresses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Go through all plans and ensure the address is associate to that user in question...';

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
        $plans = Plan::all();

        foreach($plans as $plan) {
            $plan->pet->owner->addresses()->save($plan->deliveryAddress);
        }

    }
}
