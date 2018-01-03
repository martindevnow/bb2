<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Martin\Core\Address;
use Martin\Transactions\Order;
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
        $validData = $request->validate([
            'address_id'    => 'required|exists:addresses,id',
        ]);

        $cart = \Cart::instance();

        // TODO: Create the order
        //   add order_details
        //   save order_id to session
        // Present the user with a screen to confirm the order
        //   and initiate payment
    }

    public function complete(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    
        $cart = \Cart::instance();
        $order = Order::findOrFail(session('pending_order_id'));

        $customer = Customer::create([
            'email'     => $request->get('stripeEmail'),
            'source'    => $request->get('stripeToken'),
        ]);

        Charge::create([
            'customer'  => $customer->id,
            'amount'    => round($order->total_cost * 100),
            'currency'  => 'CAD',
        ]);

    }
}
