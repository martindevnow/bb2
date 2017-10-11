<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Customers\Pet;

class PetsController extends Controller {

    public function index() {
        return Pet::with(['owner', 'plans', 'plans.package'])->get();
    }

    /**
     * Add a new Pet. Their owner must exist
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $post = $request->validate([
            'name'  => 'required',
            'breed' => '',
            'weight'    => 'required|integer|min:1',
            'birthday'  => 'date_format:Y-m-d',
            'activity_level'  => 'required|numeric|min:1',
            'owner_id'  => 'required|exists:users,id',
        ]);

        $pet = Pet::create($post);

        return $pet;
    }
}