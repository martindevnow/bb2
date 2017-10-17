<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Martin\Products\Meal;

class MealsController extends Controller {

    /**
     * Fetch a list of Meats
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[] |Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return Meal::all();
    }

}