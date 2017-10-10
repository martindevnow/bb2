<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Martin\Products\Meat;
use Martin\Subscriptions\Plan;
use Martin\Vendors\PurchaseOrder;

class PurchaseOrdersController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id) {
        $po = PurchaseOrder::find($id);

        return view('admin.purchase-orders.show')
            ->with(compact('po'));
    }

    /**
     * Show the form to generate a meat order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $plans = Plan::active()->get();

        return view('admin.purchase-orders.create')
            ->with(compact('plans'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {

        // collect the response
        $weeks_to_order = $request->get('plan_id');
        $collection = collect($weeks_to_order);

        // get the keys (ids)
        $ids = $collection->keys();

        // fetch plans::whereIn(ids)
        $plans = Plan::whereIn('id', $ids)->get();

        // create purchase order
        /** @var PurchaseOrder $po */
        $po = PurchaseOrder::create();

        // add plans
        foreach ($plans as $plan) {
            if ($weeks_to_order[$plan->id] == 0)
                continue;

            $po->addPlanToOrder($plan, $weeks_to_order[$plan->id]);
        }

        // return redirect to show this purchase order by id
        $po = $po->fresh(['details']);

        flash('Your purchase order has been prepared');

        return redirect('/admin/purchase-orders/' . $po->id);
    }
}

