<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Products\Topping;

class MealsController extends Controller
{
    public function index() {
        $meals = Meal::all();

        return view('admin.meals.index')
            ->with(compact('meals'));
    }

    public function show(Meal $meal) {
        $meats = Meat::all();
        $toppings = Topping::all();

        return view('admin.meals.show')
            ->with(compact('meal', 'meats', 'toppings'));
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

        $meal = Meal::create($request->only(['label', 'code', 'meal_value']));

        flash('Your meal '. $meal->label .' has been saved.')->success();

        return redirect('/admin/meals');
    }

    public function edit(Meal $meal) {
        return view('admin.meals.edit')
            ->with(compact('meal'));
    }

    public function update(Meal $meal, Request $request) {
        $this->validate($request, [
            'code'      => 'required',
            'label'      => 'required',
            'meal_value'   => 'required|integer|between:1,2',
        ]);

        $meal->fill($request->only(['code', 'label', 'meal_value']))
            ->save();

        flash('The meal ' . $meal->label . ' has been updated.')->success();

        return redirect('/admin/meals');
    }

    public function destroy(Meal $meal) {
        $meal->delete();

        flash('The meal ' . $meal->label . ' has been deleted.')->success();

        return redirect()->back();
    }

    /**
     * @param Meal $meal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addMeat(Meal $meal, Request $request) {
        $this->validate($request, [
            'meat_id'   => 'required|integer|exists:meats,id'
        ]);

        if ($meal->hasMeat((int) $request->meat_id)) {
            flash('That meat is already on that meal. Cannot add it twice..')->error()->important();
            return redirect()->back();
        }

        $meal->addMeat((int) $request->meat_id);
        flash('That meat was added to the meal.')->success();
        return redirect()->back();
    }

    /**
     * @param Meal $meal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeMeat(Meal $meal, Request $request) {
        $this->validate($request, [
            'meat_id'   => 'required|integer|exists:meats,id'
        ]);

        if ( ! $meal->hasMeat((int) $request->meat_id)) {
            flash('That meat does not exist on this meal.')->error()->important();
            return redirect()->back();
        }

        $meal->removeMeat((int) $request->meat_id);
        flash('That meat was removed from the meal.')->success();
        return redirect()->back();
    }

    /**
     * @param Meal $meal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addTopping(Meal $meal, Request $request) {
        $this->validate($request, [
            'topping_id'   => 'required|integer|exists:toppings,id'
        ]);

        if ($meal->hasTopping((int) $request->topping_id)) {
            flash('That topping is already on that meal. Cannot add it twice..')->error()->important();
            return redirect()->back();
        }

        $meal->addTopping((int) $request->topping_id);
        flash('That topping was added to the meal.')->success();
        return redirect()->back();
    }

    /**
     * @param Meal $meal
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeTopping(Meal $meal, Request $request) {
        $this->validate($request, [
            'topping_id'   => 'required|integer|exists:toppings,id'
        ]);

        if ( ! $meal->hasTopping((int) $request->topping_id)) {
            flash('That topping does not exist on that meal.')->error()->important();
            return redirect()->back();
        }

        $meal->removeTopping((int) $request->topping_id);
        flash('That topping was removed from the meal.')->success();
        return redirect()->back();
    }
}

