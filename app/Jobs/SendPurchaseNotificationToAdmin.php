<?php

namespace App\Jobs;

use App\Mail\PurchaseWasMadeAdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Martin\Transactions\Order;

class SendPurchaseNotificationToAdmin implements ShouldQueue
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
        \Log::info('Executing job :: SendPurchaseNotificationToAdmin');
        $order = $this->order;

        \Mail::to(['benm@barfbento.com', 'vivianw@barfbento.com'])
            ->send(new PurchaseWasMadeAdminNotification($order));
    }
}
