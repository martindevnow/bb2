<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Martin\ACL\User;
use Martin\Delivery\Courier;
use Martin\Delivery\Delivery;
use Martin\Transactions\Order;

class DeliveriesController extends Controller
{
    /**
     * Display all Deliveries
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $deliveries = Delivery::with('recipient')->get();

        return view('admin.deliveries.index')
            ->with(compact('deliveries'));
    }

    /**
     * Show one Delivery
     *
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Delivery $delivery) {
        return view('admin.deliveries.show')
            ->with(compact('delivery'));
    }

    /**
     * Show form to create a new Delivery
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $users = User::all();
        $orders = Order::all();
        $couriers = Courier::all();
        return view('admin.deliveries.create')
            ->with(compact('users', 'orders', 'couriers'));
    }

    /**
     * Store the details submitted for creating a new Delivery
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'recipient_id'  => 'required|exists:users,id',
            'order_id'      => 'required|exists:orders,id',
            'courier_id'    => 'required|exists:couriers,id',
            'shipped_at'    => 'required|date_format:Y-m-d',
        ]);

        $deliveryData = $request->only([
            'recipient_id',
            'order_id',
            'courier_id',
            'tracking_number',
            'instructions',
        ]);
        $deliveryData['shipped_at'] = $this->getDateFromRequest($request,'shipped_at');
        $deliveryData['delivered_at'] = $this->getDateFromRequest($request,'delivered_at');

        $delivery = Delivery::create($deliveryData);

        flash('The delivery with ID: ' . $delivery->id . ' was saved.')->success();

        return redirect('/admin/deliveries');
    }

    /**
     * Show the form to edit a specific Delivery
     *
     * @param Delivery $delivery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Delivery $delivery) {
        $users = User::all();
        $orders = Order::all();
        $couriers = Courier::all();
        return view('admin.deliveries.edit')
            ->with(compact('delivery', 'users', 'orders', 'couriers'));

    }

    /**
     * Update the parameters of a specific Delivery
     *
     * @param Delivery $delivery
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Delivery $delivery, Request $request) {
        $this->validate($request, [
            'recipient_id'  => 'required|exists:users,id',
            'order_id'      => 'required|exists:orders,id',
            'courier_id'    => 'required|exists:couriers,id',
            'shipped_at'    => 'required|date_format:Y-m-d',
        ]);

        $deliveryData = $request->only([
            'recipient_id',
            'order_id',
            'courier_id',
            'tracking_number',
            'instructions',
        ]);
        $deliveryData['shipped_at'] = $this->getDateFromRequest($request,'shipped_at');
        $deliveryData['delivered_at'] = $this->getDateFromRequest($request,'delivered_at');

        $delivery->fill($deliveryData);
        $delivery->save();

        flash('The delivery with ID: ' . $delivery->id . ' was updated.')->success();

        return redirect('/admin/deliveries');
    }

    /**
     * Delete an existing Delivery
     *
     * @param Delivery $delivery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Delivery $delivery) {
        $delivery->delete();

        flash('The delivery with ID: ' . $delivery->id . ' has been deleted.')->success();

        return redirect()->back();
    }

}

