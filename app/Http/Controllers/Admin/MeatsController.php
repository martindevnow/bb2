<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Martin\Products\Meat;

class MeatsController extends Controller
{
    public function index() {
        $meats = Meat::all();

        return view('admin.meats.index')
            ->with(compact('meats'));
    }

    public function show(Meat $meat) {
        return view('admin.meats.show')
            ->with(compact('meat'));
    }

    public function create() {
        return view('admin.meats.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'code'          => 'required|unique:meats',
            'type'          => 'required',
            'variety'       => 'required',
            'cost_per_lb'   => 'required|numeric',
        ]);


        $meat = Meat::create($request->only(['type', 'variety', 'code', 'cost_per_lb']));

        flash('The meat ' . $meat->type . ' - ' . $meat->variety .' was saved.')->success();

        return redirect('/admin/meats');
    }

    public function edit(Meat $meat) {
        return view('admin.meats.edit')
            ->with(compact('meat'));

    }

    public function update(Meat $meat, Request $request) {
        $this->validate($request, [
            'code'          => 'required',
            'type'          => 'required',
            'variety'       => 'required',
            'cost_per_lb'   => 'required|numeric',
        ]);

        $meat->fill($request->only(['code', 'type', 'variety', 'cost_per_lb']));
        $meat->save();

        flash('The meat ' . $meat->type . ' - ' . $meat->variety .' was updated.')->success();

        return redirect('/admin/meats');
    }

    public function destroy(Meat $meat) {
        $meat->delete();

        flash('The meat: ' . $meat->type .' - '. $meat->variety . ' has been deleted.')->success();

        return redirect()->back();
    }
}

