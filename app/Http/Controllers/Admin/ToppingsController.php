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

        $topping = Topping::create($request->only(['label', 'code', 'cost_per_kg']));

        flash('The topping ' . $topping->label . ' was saved.')->success();

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
            'cost_per_kg'   => 'required',
        ]);

        $topping->fill($request->only(['code', 'label', 'cost_per_kg']));
        $topping->save();

        flash('The topping ' . $topping->label . ' was updated.')->success();

        return redirect('/admin/toppings');
    }

    public function destroy(Topping $topping) {
        $topping->delete();

        flash('The topping: ' . $topping->label . ' has been deleted.')->success();

        return redirect()->back();
    }
}

