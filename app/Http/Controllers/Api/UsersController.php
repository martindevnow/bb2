<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Martin\Subscriptions\Package;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    public function user(Request $request) {
        return $request->user();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function pets(Request $request) {
        return $request->user()->pets;

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addresses(Request $request) {
        return $request->user()->addresses;
    }
}
