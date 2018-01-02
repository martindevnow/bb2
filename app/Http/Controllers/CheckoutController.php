<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Martin\Core\Address;
use Martin\Transactions\Order;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = \Cart::content();
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

//        $string = '';
//        foreach ($cart->content() as $item) {
//            $string .= print_r($item->toArray(), true);
//            $string .= print_r($item->model->toArray(), true);
//        }
//
//        dd ($string);

        $address = Address::createFromForm($validData);
        $order = Order::createFromCart($cart, $address);

        dd ($order);
        // TODO: Persist the Address
        //   Create the order
        //   add order_details
        //   save to session
        // Present the user with a screen to confirm the order
        //   and initiate payment
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
}
