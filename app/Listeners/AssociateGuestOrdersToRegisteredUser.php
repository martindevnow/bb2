<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Martin\ACL\User;
use Martin\Transactions\Order;

class AssociateGuestOrdersToRegisteredUser
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Registered $registeredEvent
     * @return void
     * @internal param object $event
     */
    public function handle(Registered $registeredEvent)
    {
        /** @var User $user */
        $user = $registeredEvent->user;

        \Log::info('User registered: ');
        \Log::info(print_r($user->toArray(), true));

        $orders = session('completed_orders', null);
        if (!$orders)
            \Log::info('Newly registered user didnt have any orders processed in this session.');

        \Log::info(print_r($orders, true));
        if (!! $orders && is_array($orders)) {

            foreach ($orders as $order_id) {
                \Log::info('...... searching for order with ID: '. $order_id);

                $order = Order::with(['payments', 'deliveryAddress'])->findOrFail($order_id);
                $order->update(['customer_id' => $user->id]);

                $payment = $order->payments()->first();

                $user->update(['stripe_customer_id' => $payment->stripe_customer_id]);
                $user->addresses()->save($order->deliveryAddress);
            }
            session()->remove('completed_orders');
        }
    }
}
