<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Products\Meal;

class MealsController extends Controller {

    /**
     * Fetch a list of Meats
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[] |Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return Meal::with(['meats', 'toppings'])->get();
    }

    public function store(Request $request) {
        $validData = $request->validate([
            'code'  => 'required|unique:meals,code',
            'label' => 'required|unique:meals,label',
            'meal_value' => 'required|numeric',
            'meats' => 'required',
            'toppings'  => '',
        ]);

        $meal = Meal::create($request->only(['code', 'label', 'meal_value']));
        foreach($validData['meats'] as $meatId) {
            $meal->addMeat($meatId);
        }

        foreach($validData['toppings'] as $toppingId) {
            $meal->addTopping($toppingId);
        }
        return $meal->fresh(['meats', 'toppings']);

    }

}