<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Martin\Products\Meat;
use Martin\Subscriptions\Plan;

class MeatOrdersController extends Controller
{

    /**
     * Show the form to generate a meat order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $plans = Plan::all();

        return view('admin.meats.order.create')
            ->with(compact('plans'));
    }

    public function store() {
        $plans = Plan::all();

        $plan = $plans->first();
        $numberOfWeeks = 1;

        $meatToOrder = $plan->meatToOrder($numberOfWeeks);


    }
}

