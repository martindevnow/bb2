<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Products\Meal;
use Martin\Subscriptions\Package;

class PackagesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    public function index() {
        $packages = Package::all();
        return view('admin.packages.index')
            ->with(compact('packages'));
    }

    public function show(Package $package) {
        $meals = Meal::all();

        return view('admin.packages.show')
            ->with(compact('package', 'meals'));
    }

    public function create() {
        return view('admin.packages.create');
    }

    public function store(Request $request) {
        $validData = $request->validate([
            'code'  => 'required|unique:packages,code',
            'label' => 'required',
            'level' => 'required|integer',  // TODO: Make sure single digit only... less than 10 levels, lol
            'customization' => 'nullable',  // TODO: Make sure single digit only... less than 10 levels, lol
        ]);

        $validData['customization'] = $request->customization == 'on' ? 1 : 0;

        $package = Package::create($validData);

        flash('The package ' . $package->label . ' has been saved.')->success();
        return redirect()->back();
    }

    public function edit(Package $package) {
        return view('admin.packages.edit')
            ->with(compact('package'));
    }

    public function update(Package $package, Request $request) {
        $this->validate($request, [
            'code'  => 'required',
            'label' => 'required',
            'level' => 'required|integer',  // TODO: Make sure single digit only... less than 10 levels, lol
        ]);

        $requestData = $request->only(['code', 'label', 'level']);
        $requestData['customization'] = $request->customization == 'on' ? 1 : 0;
        $package->fill($requestData)
            ->save();

        flash('The package ' . $package->label . ' has been updated.')->success();
        return redirect('/admin/packages');
    }

    public function destroy(Package $package) {
        $package->delete();

        flash('The package ' . $package->label . ' has been deleted.')->success();
        return redirect()->back();
    }

    /**
     * AJAX request only...
     * TODO: This should be separated out to an Class to handle AJAX calls
     *
     * @param Package $package
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function setMeal(Package $package, Request $request) {
        $this->validate($request, [
            'meal_id'       => 'required|exists:meals,id',
            'calendar_code' => 'required'
        ]);

        $meal = Meal::findOrFail($request->get('meal_id'));
        $package->addMeal($meal, $request->get('calendar_code'));

        return response(null, 200);
    }

    /**
     * @param Package $package
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCalendar(Package $package, Request $request) {
        $this->validate($request, [
            'selected-1B'  => 'required|integer|exists:meals,id',
            'selected-2B'  => 'required|integer|exists:meals,id',
            'selected-3B'  => 'required|integer|exists:meals,id',
            'selected-4B'  => 'required|integer|exists:meals,id',
            'selected-5B'  => 'required|integer|exists:meals,id',
            'selected-6B'  => 'required|integer|exists:meals,id',
            'selected-7B'  => 'required|integer|exists:meals,id',
            'selected-1D'  => 'required|integer|exists:meals,id',
            'selected-2D'  => 'required|integer|exists:meals,id',
            'selected-3D'  => 'required|integer|exists:meals,id',
            'selected-4D'  => 'required|integer|exists:meals,id',
            'selected-5D'  => 'required|integer|exists:meals,id',
            'selected-6D'  => 'required|integer|exists:meals,id',
            'selected-7D'  => 'required|integer|exists:meals,id',
        ]);

        foreach($request->all() as $param => $val) {
            if (strpos($param, 'selected') !== false) {
                $day = explode('-', $param)[1];
                $package->addMeal((int) $val, $day);
            }
        }

        flash('The calendar has been updated as shown below.')->success();
        return redirect()->back();
    }

}
