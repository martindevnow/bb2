<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Core\Address;
use Martin\Delivery\Courier;

class AddressesController extends Controller {

    /**
     * Fetch a list of Couriers
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[] |Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return Address::all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $validData = $request->validate([
            'name'          => 'nullable',
            'description'   => 'nullable',
            'company'       => 'nullable',
            'street_1'      => 'required',
            'street_2'      => 'nullable',
            'city'          => 'required',
            'province'      => 'required',
            'postal_code'   => 'required',
            'country'       => 'required',
            'phone'         => 'nullable',
            'buzzer'        => 'nullable',
        ]);

        $address = Address::create($validData);
        return $address;
    }

    /**
     * @param Address $address
     * @param Request $request
     * @return mixed
     */
    public function update(Address $address, Request $request) {
        $validData = $request->validate([
            'name'          => 'nullable',
            'description'   => 'nullable',
            'company'       => 'nullable',
            'street_1'      => 'required',
            'street_2'      => 'nullable',
            'city'          => 'required',
            'province'      => 'required',
            'postal_code'   => 'required',
            'country'       => 'required',
            'phone'         => 'nullable',
            'buzzer'        => 'nullable',
        ]);

        $address->update($validData);
        return $address->fresh();
    }

    public function destroy($id) {
        if (Address::where($id)->delete()) {
            return response('Success', 200);
        }
        return response('Error', 500);
    }

}