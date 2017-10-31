<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Martin\Delivery\Courier;

class CouriersController extends Controller {

    /**
     * Fetch a list of Couriers
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[] |Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return Courier::all();
    }

}