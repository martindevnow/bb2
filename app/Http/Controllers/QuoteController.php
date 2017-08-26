<?php

namespace App\Http\Controllers;

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
     * @param $hash
     * @return $this
     */
    public function subscribe($hash) {
        $cart = ShoppingCart::byHash($hash);

        session(['cart.hash' => $hash]);

        if (auth()->user())
            redirect('/quote/pet');
        return view('quote.subscribe')
            ->with(compact($cart));
    }

    /**
     * @return $this
     */
    public function pet() {
        $hash = session('cart.hash');
        $cart = ShoppingCart::byHash($hash);

        $pets = auth()->user()->pets();

        return view('quote.pet')
            ->with(compact('pets', 'cart'));
    }

}
