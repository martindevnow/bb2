<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * Display the Product Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin.products.index');
    }
}

