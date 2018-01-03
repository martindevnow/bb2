<?php

namespace App\Http\Controllers;

use App\Jobs\SendPurchaseNotificationToAdmin;
use App\Jobs\SendPurchaseNotificationToCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Martin\Core\Address;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = \Cart::content();

        if (! $cart->count()) {
            return redirect('/cart');
        }

        return view('checkout.delivery')
            ->with(compact('cart'));
    }

    public function newAddress() {
        $cart = \Cart::instance();

        return view('checkout.newAddress')
            ->with(compact('cart'));
    }

    public function storeNewAddress(Request $request) {
        $validData = $request->validate([
            'name'          => 'required',
            'street_1'      => 'required',
            'street_2'      => 'nullable',
            'city'          => 'required',
            'province'      => 'required',
            'postal_code'   => 'required',
        ]);

        // FUTURE: Allow shipping to other countries
        if (! isset($validData['country']))
            $validData['country'] = "Canada";

        $address = Address::createFromForm($validData);
        $request->user()->addresses()->save($address);

        return redirect('/checkout');
    }

    public function guest(Request $request) {
        $validData = $request->validate([
            'name'          => 'required',
            'street_1'      => 'required',
            'street_2'      => 'nullable',
            'city'          => 'required',
            'province'      => 'required',
            'postal_code'   => 'required',
        ]);

        // FUTURE: Allow shipping to other countries
        if (! isset($validData['country']))
            $validData['country'] = "Canada";

        $cart = \Cart::instance();
        $address = Address::createFromForm($validData);
        $order = Order::createFromCart($cart, $address);

        session(['pending_order_id' => $order->id]);

        $cart = $cart->content();
        return view('checkout.confirm')->with(compact('cart', 'order'));
    }

    public function member(Request $request) {
        // TODO: Add another route where the user can add a new address and redirect back to this page...

        $validData = $request->validate([
            'address_id'    => 'required|exists:addresses,id',
        ]);

        $address = Address::findOrFail($request->get('address_id'));

        if ($address->addressable_id != $request->user()->id) {
            return redirect()->withErrors()->back();
        }

        $cart = \Cart::instance();
        $order = Order::createFromCart($cart, $address);

        session(['pending_order_id' => $order->id]);

        $cart = $cart->content();
        return view('checkout.confirm')->with(compact('cart', 'order'));
    }

    public function complete(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    
        /** @var Order $order */
        $order = Order::findOrFail(session('pending_order_id'));

        $customer = Customer::create([
            'email'     => $request->get('stripeEmail'),
            'source'    => $request->get('stripeToken'),
        ]);

        $charge = Charge::create([
            'customer'  => $customer->id,
            'amount'    => round($order->total_cost * 100),
            'currency'  => 'CAD',
        ]);

        // TODO: Add validation that the charge was actually successful
        if ($everything_works_ok = true) {

            if (!! $request->user()) {
                $user = $request->user();
                $user->update([
                    'stripe_customer_id'    => $customer->id,
                ]);
            }

            $payment = Payment::create([
                'received_at'   => Carbon::now(),
                'format'        => 'stripe',
                'amount_paid'   => $order->total_cost,
                'stripe_customer_email' => $request->get('stripeEmail'),
                'stripe_customer_id'    => $request->get('stripeToken'),
            ]);
            $order->markAsPaid($payment);

            \Cart::destroy();

            session()->remove('pending_order_id');

            if (session('completed_orders')) {
                $completed_orders = session('completed_orders');
            } else {
                $completed_orders = [];
            }
            array_push($completed_orders, $order->id);
            session(compact('completed_orders'));

            //  EMAIL
            $this->dispatch(new SendPurchaseNotificationToAdmin($order));
            $this->dispatch(new SendPurchaseNotificationToCustomer($order));

            return view('checkout.success');
        }

    }
}
