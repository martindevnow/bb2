<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Products\Meat;

class MeatsController extends Controller {

    /**
     * Fetch a list of Meats
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[] |Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return Meat::all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $validData = $request->validate([
            'code'  => 'required|unique:meats,code',
            'type'  => 'required',
            'variety'       => 'required',
            'cost_per_lb'   => 'required|numeric',
            'has_bone'      => 'nullable',
        ]);

        $meat = Meat::create($validData);

        return $meat;
    }

}