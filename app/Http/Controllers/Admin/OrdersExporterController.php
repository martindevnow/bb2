<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersExporterController extends Controller
{

    /**
     * Show the form to export the orders
     */
    public function index() {
        return view('admin.orders.exporter.index');
    }

    public function prepare(Request $request) {

        $request->validate([
            'purpose'   => 'required',
            'shipping_out_by'   => 'required|date_format:Y-m-d',
        ]);

        if ($request->get('purpose') == 'packing_orders')
            return $this->forPackingOrders($request);

        if ($request->get('purpose') == 'ordering_meat')
            return $this->forOrderingMeat($request);
    }

    private function forOrderingMeat(Request $request) {
        $shipping_by = $request->get('shipping_out_by');



    }

    private function forPackingOrders(Request $request) {
        $shipping_by = $request->get('shipping_out_by');

    }
}
