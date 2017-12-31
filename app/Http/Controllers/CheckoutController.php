<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
              $cart = \Cart::content();
        return view('checkout.delivery')
            ->with(compact('cart'));
    }
}
