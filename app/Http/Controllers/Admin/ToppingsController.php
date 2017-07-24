<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Products\Topping;

class ToppingsController extends Controller
{
    /**
     * Display all Toppings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $toppings = Topping::all();

        return view('admin.toppings.index')
            ->with(compact('toppings'));
    }

    /**
     * Show one Topping
     *
     * @param Topping $topping
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Topping $topping) {
        return view('admin.toppings.show')
            ->with(compact('topping'));
    }

    /**
     * Show form to create a new Topping
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('admin.toppings.create');
    }

    /**
     * Store the details submitted for creating a new Topping
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Show the form to edit a specific Topping
     *
     * @param Topping $topping
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Topping $topping) {
        return view('admin.toppings.edit')
            ->with(compact('topping'));

    }

    /**
     * Update the parameters of a specific Topping
     *
     * @param Topping $topping
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Delete an existing Topping
     *
     * @param Topping $topping
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Topping $topping) {
        $topping->delete();

        flash('The topping: ' . $topping->label . ' has been deleted.')->success();

        return redirect()->back();
    }
}

