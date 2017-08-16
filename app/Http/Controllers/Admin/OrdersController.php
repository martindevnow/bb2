<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Transactions\Order;

class OrdersController extends Controller
{
    /**
     * Display all Orders
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $orders = Order::all();

        return view('admin.orders.index')
            ->with(compact('orders'));
    }

    /**
     * Show one Order
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Order $order) {
        $meals = $order->mealCounts();
        return view('admin.orders.show')
            ->with(compact('order', 'meals'));
    }

    /**
     * Show form to create a new Order
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('admin.orders.create');
    }

    /**
     * Store the details submitted for creating a new Order
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'plan_id'               => 'required|exists:orders,id',
            'customer_id'           => 'required|exists:users,id',
            'delivery_address_id'   => 'required|exists:addresses,id',
            'subtotal'      => 'required|numeric',
            'tax'           => 'required|numeric',
            'total_cost'    => 'required|numeric',
        ]);

        if ($request->get('subtotal') + $request->get('tax') !== $request->get('total_cost')) {
            flash('The subtotal + tax must equal the total_cost')->error()->important();
            return redirect()->back()->withInput();
        }

        $order = Order::create($request->only([
            'plan_id',
            'customer_id',
            'delivery_address_id',
            'subtotal',
            'tax',
            'total_cost',
        ]));

        flash('The order with ID: ' . $order->id . ' was saved.')->success();

        return redirect('/admin/orders');
    }

    /**
     * Show the form to edit a specific Order
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Order $order) {
        return view('admin.orders.edit')
            ->with(compact('order'));

    }

    /**
     * Update the parameters of a specific Order
     *
     * @param Order $order
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Order $order, Request $request) {
        $this->validate($request, [
            'plan_id'               => 'required|exists:orders,id',
            'customer_id'           => 'required|exists:users,id',
            'delivery_address_id'   => 'required|exists:addresses,id',
            'subtotal'      => 'required|numeric',
            'tax'           => 'required|numeric',
            'total_cost'    => 'required|numeric',
        ]);

        $order->fill($request->only([
            'plan_id',
            'customer_id',
            'delivery_address_id',
            'subtotal',
            'tax',
            'total_cost',
        ]));
        $order->save();

        flash('The order with ID: ' . $order->id . ' was updated.')->success();

        return redirect('/admin/orders');
    }

    /**
     * Delete an existing Order
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order) {
        $order->delete();

        flash('The order with ID: ' . $order->id . ' has been deleted.')->success();

        return redirect()->back();
    }

    public function packed(Order $order) {
        $order->markAsPacked();
        $order->save();

        flash('Thank you for packing that order.');

        return redirect()->back();
    }
}

