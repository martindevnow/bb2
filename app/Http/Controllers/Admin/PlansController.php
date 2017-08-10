<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Martin\ACL\User;
use Martin\Customers\Pet;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;

class PlansController extends Controller
{
    /**
     * Display all Plans
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $plans = Plan::with(['customer', 'pet', 'package'])->get();

        return view('admin.plans.index')
            ->with(compact('plans'));
    }

    /**
     * Show one Plan
     *
     * @param Plan $plan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Plan $plan) {
        return view('admin.plans.show')
            ->with(compact('plan'));
    }

    /**
     * Show form to create a new Plan
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $pets = Pet::with(['owner'])->get();
        $packages = Package::all();
        return view('admin.plans.create')
            ->with(compact('pets', 'packages'));
    }

    /**
     * Store the details submitted for creating a new Plan
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'pet_id'                => 'required',
            'package_id'            => 'required',

            'shipping_cost'         => 'required',
            'weekly_cost'           => 'required',
            'weeks_at_a_time'       => 'required',
            'active'                => 'required'
        ]);

        $planData = $request->only([
            'shipping_cost',
            'pet_id',
            'package_id',
            'weekly_cost',
            'weeks_at_a_time',
            'active'
        ]);

        /** @var Pet $pet */
        $pet = Pet::findOrFail($request->get('pet_id'));
        $planData['pet_weight'] = $pet->weight;
        $planData['pet_activity_level'] = $pet->activity_level;
        $planData['customer_id'] = $pet->owner_id;

        $plan = Plan::create($planData);

        flash('The plan for customer' . $plan->customer->name . ' was saved.')->success();

        return redirect('/admin/plans');
    }

    /**
     * Show the form to edit a specific Plan
     *
     * @param Plan $plan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Plan $plan) {
        $pets = Pet::with(['owner'])->get();
        $packages = Package::all();
        return view('admin.plans.edit')
            ->with(compact('plan','pets', 'packages'));

    }

    /**
     * Update the parameters of a specific Plan
     *
     * @param Plan $plan
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Plan $plan, Request $request) {
        $this->validate($request, [
            'customer_id'           => 'required',
            'delivery_address_id'   => 'required',
            'shipping_cost'         => 'required',

            'pet_id'                => 'required',
            'pet_weight'            => 'required',
            'pet_activity_level'    => 'required',

            'package_id'            => 'required',
            'package_stripe_code'   => 'required',
            'package_base'          => 'required',

            'weekly_cost'           => 'required',
            'weeks_at_a_time'       => 'required',
        ]);

        $planData = $request->only([
            'customer_id',
            'delivery_address_id',
            'shipping_cost',

            'pet_id',
            'pet_weight',
            'pet_activity_level',

            'package_id',
            'package_stripe_code',
            'package_base',

            'weekly_cost',

            'weeks_at_a_time',
            'active']);

        $plan->fill($planData);
        $plan->save();

        flash('The plan of $' . $plan->amount_paid . ' was updated.')->success();

        return redirect('/admin/plans');
    }

    /**
     * Delete an existing Plan
     *
     * @param Plan $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Plan $plan) {
        $plan->delete();

        flash('The plan of $' . $plan->amount_paid . ' has been deleted.')->success();

        return redirect()->back();
    }
}

