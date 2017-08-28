<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Martin\Subscriptions\Package;
use Martin\Transactions\ShoppingCart;

class ShoppingCartsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    /**
     * @param $hash
     * @return \Illuminate\Http\Response
     */
    public function cartByHash($hash) {
        return ShoppingCart::byHash($hash);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addresses(Request $request) {
        return $request->user()->addresses;
    }
}
