<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Customers\Pet;

class PetsController extends Controller
{
    /**
     * Display all Pets
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $pets = Pet::with('owner')->get();

        return view('admin.pets.index')
            ->with(compact('pets'));
    }

    /**
     * Show one Pet
     *
     * @param Pet $pet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Pet $pet) {
        return view('admin.pets.show')
            ->with(compact('pet'));
    }

    /**
     * Show form to create a new Pet
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('admin.pets.create');
    }

    /**
     * Store the details submitted for creating a new Pet
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name'      => 'required',
            'weight'    => 'required',
            'activity_level'    => 'required',
        ]);

        $pet = Pet::create($request->only(['name', 'weight', 'species', 'breed', 'activity_level', 'birthday']));

        flash('The pet ' . $pet->name . ' was saved.')->success();

        return redirect('/admin/pets');
    }

    /**
     * Show the form to edit a specific Pet
     *
     * @param Pet $pet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Pet $pet) {
        return view('admin.pets.edit')
            ->with(compact('pet'));

    }

    /**
     * Update the parameters of a specific Pet
     *
     * @param Pet $pet
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Pet $pet, Request $request) {
        $this->validate($request, [
            'name'      => 'required',
            'weight'    => 'required',
            'activity_level'    => 'required',
        ]);

        $petData = $request->only(['name', 'weight', 'species', 'breed', 'activity_level', 'birthday']);

        $pet->fill($petData);
        $pet->save();

        flash('The pet ' . $pet->name . ' was updated.')->success();

        return redirect('/admin/pets');
    }

    /**
     * Delete an existing Pet
     *
     * @param Pet $pet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pet $pet) {
        $pet->delete();

        flash('The pet: ' . $pet->name . ' has been deleted.')->success();

        return redirect()->back();
    }
}

