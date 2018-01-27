<?php

namespace App\Jobs;

use App\Mail\PurchaseWasMadeCustomerNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Martin\Transactions\Order;

class SendPurchaseNotificationToCustomer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Executing event listener :: NotifyUserOfPurchase');

        $order = $this->order;
        $customer_email = $this->order->payments()->first()->stripe_customer_email;

        \Mail::to($customer_email)
            ->send(new PurchaseWasMadeCustomerNotification($order));
    }
}
