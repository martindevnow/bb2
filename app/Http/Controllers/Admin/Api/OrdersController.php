<?php

namespace App\Http\Controllers\Admin\Api;

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
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index() {
        return Order::with([
            'customer',
            'plan.pet',
            'plan',
            'plan.package',
            'deliveryAddress'
        ])->get();
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function packed(Order $order) {
        $order->markAsPacked();
        $order->save();
        return response('success', 200);
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storePayment(Order $order, Request $request) {
        $paymentData = $request->validate([
            'format'        => 'required',
            'amount_paid'   => 'required|numeric|min:1',
            'received_at'   => 'required|date_format:Y-m-d',
        ]);
        $paymentData['customer_id'] = $order->customer_id;
        $paymentData['collector_id'] = Auth::user()->id;

        $payment = Payment::make($paymentData);
        if ($order->markAsPaid($payment)) {
            return response('success', 200);
        }

        return response('', 422)->withErrors();
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function markAsPacked(Order $order, Request $request) {
        $packedData = $request->validate([
            'weeks_packed'      => 'required|integer|min:1',
            'packed_package_id' => 'required|exists:packages,id',
        ]);

        $order->markAsPacked($packedData);

        return response('success', 200);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function markAsPicked(Order $order) {
        $order->markAsPicked();
        return response('success', 200);
    }

    public function storeShipment(Order $order, Request $request) {
        $deliveryData = $request->validate([
            'courier_id'            => 'required|exists:couriers,id',
            'shipped_at'            => 'required|date_format:Y-m-d',
            'weeks_shipped'         => 'required|integer|min:1',
            'shipped_package_id'    => 'required|exists:packages,id',
            'tracking_number'       => '',
            'instructions'          => '',
        ]);

        $delivery = Delivery::make($deliveryData);
        $order->markAsShipped($delivery);
        return response('success', 200);
    }

    public function storeDelivery(Order $order, Request $request) {
        $request->validate([
            'delivered_at'    => 'required|date_format:Y-m-d',
        ]);

        $delivery = $order->delivery;
        $delivery->delivered_at = $request->get('delivered_at');
        $delivery->save();
        $order->markAsDelivered();
        return response('success', 200);
    }

    public function cancel(Order $order) {
        if ( ! $order->notes->count()) {
            return response(['error' => 'no note was saved...'], 500);
        }

        $order->cancel();
        return response('success', 200);
    }

    public function updateDeliverBy(Order $order, Request $request) {
        $validData = $request->validate([
            'deliver_by'    => 'required|date_format:Y-m-d',
            'updateFuture'  => 'nullable',
        ]);

        $order->updateDeliverBy($validData['deliver_by'], $validData['updateFuture']);
        return response('Success', 200);
    }
}

