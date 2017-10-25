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
        return Package::with(['meals'])->get();
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

//        $validData['customization'] = $request->customization == 'on' ? 1 : 0;
//        $validData['active'] = $request->active == 'on' ? 1 : 0;
//        $validData['public'] = $request->public == 'on' ? 1 : 0;

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

//        $validData['customization'] = $request->customization == 'on' ? 1 : 0;
//        $validData['active'] = $request->active == 'on' ? 1 : 0;
//        $validData['public'] = $request->public == 'on' ? 1 : 0;

        $package->update($validData);
        return $package->fresh(['meals']);
    }
}