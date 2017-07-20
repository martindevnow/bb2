<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Martin\Products\Meal;

class MealsController extends Controller
{
    public function index() {
        $meals = Meal::all();

        return view('admin.meals.index')
            ->with(compact('meals'));
    }

    public function show(Meal $meal) {
        return view('admin.meals.show')
            ->with(compact('meal'));
    }

    public function create() {
        return view('admin.meals.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'code'          => 'required|unique:meals',
            'label'         => 'required',
            'meal_value'    => 'required|integer|between:1,2',
        ]);

        Meal::create($request->only(['label', 'code', 'meal_value']));
        return redirect('/admin/meals');
    }

    public function edit(Meal $meal) {
        return view('admin.meals.edit')
            ->with(compact('meal'));

    }

    public function update(Meal $meal, Request $request) {
        $this->validate($request, [
            'code'      => 'required',
            'type'      => 'required',
            'variety'   => 'required',
        ]);

        $meal->fill($request->only(['code', 'type', 'variety', 'cost_per_lb']));
        $meal->save();
        return redirect('/admin/meals');
    }
}

