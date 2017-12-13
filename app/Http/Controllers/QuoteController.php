<?php

namespace App\Http\Controllers;

use Martin\Subscriptions\Plan;
use Martin\Transactions\ShoppingCart;

class QuoteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('quote.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculator() {
        return view('quote.calculator');
    }

    /**
     * This builds the basic cart to preserve it through login.registration
     *
     * @param $hash
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subscribe($hash) {
        $cart = ShoppingCart::byHash($hash);

        session(['cart.hash' => $hash]);

        if (auth()->user())
            return redirect('/quote/details/' . $hash);

        return view('quote.subscribe')
            ->with(compact('cart', 'hash'));
    }

    /**
     * This saves displays the pet details (if any)
     * and allows the user to set address and/or pet details
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($hash) {
        $cart = ShoppingCart::byHash($hash);

        return view('quote.details')
            ->with(compact('hash'));
    }

    /**
     * @param $hash
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm($hash) {
        $cart = ShoppingCart::byHash($hash);
        $plan = Plan::byHash($hash);
        return view('quote.confirm')
            ->with(compact('cart', 'plan', 'hash'));
    }

}
