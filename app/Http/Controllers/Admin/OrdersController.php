<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Martin\Delivery\Courier;
use Martin\Delivery\Delivery;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;
use mikehaertl\wkhtmlto\Pdf;

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
            'subtotal'              => 'required|numeric',
            'tax'                   => 'required|numeric',
            'total_cost'            => 'required|numeric',
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
            'subtotal'              => 'required|numeric',
            'tax'                   => 'required|numeric',
            'total_cost'            => 'required|numeric',
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

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function packed(Order $order) {
        $order->markAsPacked();
        $order->save();

        flash('Thank you for packing that order.');

        return redirect()->back();
    }

    public function export($status, $perPage = 4) {
        switch($status) {
            case 'packing':
                $orders = Order::needsPacking();
                break;
            case 'picking':
                $orders = Order::needsPicking();
                break;
            default:
                flash('Invalid type')->error();
                return redirect()->back();
        }
        $orders = $orders->get();

        $time = time();
        $path = base_path() .'/pdfs/'. $time .'.pdf';

        $orientation = $perPage == 4 ? 'Landscape' : 'Portrait';

        $options = [
            'orientation'  => $orientation,
            'no-outline',         // Make Chrome not complain
            'margin-top'    => 5,
            'margin-right'  => 5,
            'margin-bottom' => 5,
            'margin-left'   => 5,
        ];

        $html =  view('admin.orders.export')
            ->with(compact('orders', 'perPage'))
            ->render();

        $pdf = new Pdf($options);
        $pdf->addPage($html);

        if ($pdf->saveAs($path)) {
            return response()->download($path);

        }
        return 'There was an error saving...' . $pdf->getError();
    }

    /**
     * @return $this
     */
    public function exportView($perPage = 4) {
        $orders = Order::needsPacking()->get();
        return view('admin.orders.export')
            ->with(compact('orders', 'perPage'));
    }

    /**
     * Show the form to log a payment on this Order
     *
     * @param Order $order
     * @return $this
     */
    public function createPayment(Order $order) {
        return view('admin.orders.payment')
            ->with(compact('order'));
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storePayment(Order $order, Request $request) {
        $this->validate($request, [
            'format'        => 'required',
            'amount_paid'   => 'required|numeric',
            'received_at'   => 'required|date_format:Y-m-d',
        ]);
        $paymentData = $request->only(['format', 'amount_paid', 'received_at']);
        $paymentData['customer_id'] = $order->customer_id;
        $paymentData['collector_id'] = Auth::user()->id;

        $payment = Payment::make($paymentData);
        if ($order->markAsPaid($payment)) {
            flash('That order was marked as paid.');
            return redirect('/admin/orders');
        }

        flash('There was an unexpected error...')->error();
        return redirect()->back()->withInput()->withErrors();
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function markAsPacked(Order $order) {
        $order->markAsPacked();

        flash('That order was marked as packed.');
        return redirect('/admin/orders/');
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function markAsPicked(Order $order) {
        $order->markAsPicked();

        flash('That order was marked as picked.');
        return redirect('/admin/orders');
    }

    public function createShipment(Order $order) {
        $couriers = Courier::all();
        return view('admin.orders.shipment')
            ->with(compact('order', 'couriers'));
    }

    public function storeShipment(Order $order, Request $request) {
        $this->validate($request, [
            'courier_id'    => 'required|exists:couriers,id',
            'shipped_at'    => 'required|date_format:Y-m-d',
        ]);

        $deliveryData = $request->only([
            'courier_id',
            'shipped_at',
            'tracking_number',
            'instructions'
        ]);

        $delivery = Delivery::make($deliveryData);
        $order->markAsShipped($delivery);

        flash('That order was marked as shipped.');
        return redirect('/admin/orders');
    }
    public function createDelivery(Order $order) {
        return view('admin.orders.delivery')
            ->with(compact('order'));
    }

    public function storeDelivery(Order $order, Request $request) {
        $this->validate($request, [
            'delivered_at'    => 'required|date_format:Y-m-d',
        ]);

        $delivery = $order->delivery;
        $delivery->delivered_at = $request->get('delivered_at');
        $delivery->save();
        $order->markAsDelivered();

        flash('That order was marked as delivered.');
        return redirect('/admin/orders');
    }
}

