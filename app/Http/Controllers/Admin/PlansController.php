<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Martin\ACL\User;
use Martin\Subscriptions\Plan;

class PlansController extends Controller
{
    /**
     * Display all Plans
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $plans = Plan::with('customer')->get();

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
        $users = User::all();
        return view('admin.plans.create')
            ->with(compact('users'));
    }

    /**
     * Store the details submitted for creating a new Plan
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'customer_id'   => 'required|integer',
            'amount_paid'   => 'required|numeric',
            'format'        => 'required',
            'received_at'   => 'required',
        ]);

        $planData = $request->only(['customer_id', 'amount_paid', 'format']);
        $planData['collector_id'] = Auth::id();
        $planData['received_at'] = Carbon::createFromFormat('Y-m-d', $request->get('received_at'));

        $plan = Plan::create($planData);

        flash('The plan of $' . $plan->amount_paid . ' was saved.')->success();

        return redirect('/admin/plans');
    }

    /**
     * Show the form to edit a specific Plan
     *
     * @param Plan $plan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Plan $plan) {
        $users = User::all();
        return view('admin.plans.edit')
            ->with(compact('plan', 'users'));

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
            'customer_id'   => 'required|integer',
            'amount_paid'   => 'required|numeric',
            'format'        => 'required',
            'received_at'   => 'required',
        ]);

        $planData = $request->only(['customer_id', 'amount_paid', 'format']);
//        $planData['collector_id'] = Auth::id();
        $planData['received_at'] = Carbon::createFromFormat('Y-m-d', $request->get('received_at'));


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

