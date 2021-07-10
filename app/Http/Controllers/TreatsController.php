<?php

namespace App\Http\Controllers;

use Martin\Products\Product;

class TreatsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $treats = Product::active()->get();
        return view('treats.index')->with(compact('treats'));
    }

    /**
     * @param $sku
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($sku) {
        $treat = Product::active()->whereSku($sku)->firstOrFail();
        return view('treats.show')->with(compact('treat'));
    }
}
