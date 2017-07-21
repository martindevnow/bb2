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
        $this->validate($request, [
            'code'  => 'required|unique:packages',
            'label' => 'required'
        ]);

        $package = Package::create($request->only(['code', 'label']));

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
        ]);

        $package->fill($request->only(['code', 'label']))
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
            'meal_id'   => 'required|integer',
            'calendar_code' => 'required'
        ]);

        $meal = Meal::findOrFail($request->get('meal_id'));
        $package->addMeal($meal, $request->get('calendar_code'));

        return response(null, 200);
    }

}
