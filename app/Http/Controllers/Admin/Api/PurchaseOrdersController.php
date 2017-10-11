<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Martin\Delivery\Courier;
use Martin\Delivery\Delivery;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;
use Martin\Vendors\PurchaseOrder;
use mikehaertl\wkhtmlto\Pdf;

class PurchaseOrdersController extends Controller
{
    /**
     * @param PurchaseOrder $purchaseOrder
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReceived(PurchaseOrder $purchaseOrder, Request $request) {
//        dd ($request->all());
        $validData = $request->validate([
            'received_at'   => 'required|date_format:Y-m-d'
        ]);

        $purchaseOrder->markAsReceived($validData);
        return response($purchaseOrder, 200);
    }

    /**
     * @param PurchaseOrder $purchaseOrder
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeOrdered(PurchaseOrder $purchaseOrder, Request $request) {
        $validData = $request->validate([
            'ordered_at'   => 'required|date_format:Y-m-d',
        ]);

        $purchaseOrder->markAsOrdered($validData);
        return response($purchaseOrder, 200);
    }

}

