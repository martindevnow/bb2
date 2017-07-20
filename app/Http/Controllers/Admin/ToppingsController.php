<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Products\Topping;

class ToppingsController extends Controller
{
    public function index() {
        $toppings = Topping::all();

        return view('admin.toppings.index')
            ->with(compact('toppings'));
    }

    public function show(Topping $topping) {
        return view('admin.toppings.show')
            ->with(compact('topping'));
    }

    public function create() {
        return view('admin.toppings.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'code'          => 'required|unique:toppings',
            'label'         => 'required',
            'cost_per_kg'   => 'required',
        ]);

        Topping::create($request->only(['label', 'code', 'cost_per_kg']));
        return redirect('/admin/toppings');
    }

    public function edit(Topping $topping) {
        return view('admin.toppings.edit')
            ->with(compact('topping'));

    }

    public function update(Topping $topping, Request $request) {
        $this->validate($request, [
            'code'      => 'required',
            'label'      => 'required',
            'cost_per_kg'   => 'required|integer',
        ]);

        $topping->fill($request->only(['code', 'label', 'cost_per_kg']));
        $topping->save();
        return redirect('/admin/toppings');
    }
}

