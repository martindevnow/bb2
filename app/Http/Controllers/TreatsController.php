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

    public function index() {
        $treats = Product::all();
        return view('treats.index')->with(compact('treats'));
    }

    public function show($sku) {
        $treat = Product::whereSku($sku)->firstOrFail();
        return view('treats.show')->with(compact('treat'));
    }
}
