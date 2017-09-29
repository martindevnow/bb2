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
        $this->validate($request, [
            'weeks_packed'  => 'required|numeric',
            'packed_package_id' => 'required|exists:pacakges,id',
        ]);

        $order->markAsPacked($request->only([
            'weeks_packed',
            'packed_package_id',
        ]));

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
        return response('success', 200);
    }

    public function storeDelivery(Order $order, Request $request) {
        $this->validate($request, [
            'delivered_at'    => 'required|date_format:Y-m-d',
        ]);

        $delivery = $order->delivery;
        $delivery->delivered_at = $request->get('delivered_at');
        $delivery->save();
        $order->markAsDelivered();
        return response('success', 200);
    }
}

