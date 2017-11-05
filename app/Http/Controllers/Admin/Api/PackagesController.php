<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Subscriptions\Package;

class PackagesController extends Controller {

    /**
     * Fetch a list of Packages
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[] |Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return Package::with(['meals', 'meals.meats'])->get();
    }

    /**
     * Add a new Package
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $validData = $request->validate([
            'label'         => 'required',
            'code'          => 'required|unique:packages,code',
            'level'         => 'required|integer',
            'customization' => 'nullable',
            'active'        => 'nullable',
            'public'        => 'nullable',
        ]);

        $package = Package::create($validData);

        return $package;
    }

    public function update(Package $package, Request $request) {
        $validData = $request->validate([
            'label'         => 'required',
            'code'          => 'required',
            'level'         => 'required|integer',
            'customization' => 'nullable',
            'active'        => 'nullable',
            'public'        => 'nullable',
        ]);

        $package->update($validData);
        return $package->fresh(['meals']);
    }
}