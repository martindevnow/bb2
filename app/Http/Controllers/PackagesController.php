<?php

namespace App\Http\Controllers;

use Martin\Subscriptions\Package;

class PackagesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $packages = Package::all();
        return view('packages.index')->with(compact('packages'));
    }

}
