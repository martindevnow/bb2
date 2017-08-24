<?php

namespace App\Http\Controllers;

use Stripe\{Charge, Customer};

class PlansController extends Controller
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
        return view('plans.index');
    }


    public function subscribe() {

        $customer = Customer::create([
            'email'     => request('stripeEmail'),
            'source'    => request('stripeToken'),
        ]);

        Charge::create([
            'customer'  => $customer->id,
            'amount'    => 2500,
            'currency'  => 'cad',
        ]);
    }
}
