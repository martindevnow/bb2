<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Martin\ACL\User;
use Martin\Transactions\Payment;

class PaymentsController extends Controller
{
    /**
     * Display all Payments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $payments = Payment::with('customer')->get();

        return view('admin.payments.index')
            ->with(compact('payments'));
    }

    /**
     * Show one Payment
     *
     * @param Payment $payment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Payment $payment) {
        return view('admin.payments.show')
            ->with(compact('payment'));
    }

    /**
     * Show form to create a new Payment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $users = User::all();
        return view('admin.payments.create')
            ->with(compact('users'));
    }

    /**
     * Store the details submitted for creating a new Payment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $this->validate($request, [
            'customer_id'   => 'required|exists:users,id',
            'amount_paid'   => 'required|numeric',
            'format'        => 'required',
            'received_at'   => 'required|date_format:Y-m-d',
        ]);

        $paymentData = $request->only(['customer_id', 'amount_paid', 'format']);
        $paymentData['collector_id'] = Auth::id();
        $paymentData['received_at'] = Carbon::createFromFormat('Y-m-d', $request->get('received_at'));

        $payment = Payment::create($paymentData);

        flash('The payment of $' . $payment->amount_paid . ' was saved.')->success();

        return redirect('/admin/payments');
    }

    /**
     * Show the form to edit a specific Payment
     *
     * @param Payment $payment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Payment $payment) {
        $users = User::all();
        return view('admin.payments.edit')
            ->with(compact('payment', 'users'));

    }

    /**
     * Update the parameters of a specific Payment
     *
     * @param Payment $payment
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Payment $payment, Request $request) {
        $this->validate($request, [
            'customer_id'   => 'required|exists:users,id',
            'amount_paid'   => 'required|numeric',
            'format'        => 'required',
            'received_at'   => 'required|date_format:Y-m-d',
        ]);

        $paymentData = $request->only(['customer_id', 'amount_paid', 'format']);
//        $paymentData['collector_id'] = Auth::id();
        $paymentData['received_at'] = Carbon::createFromFormat('Y-m-d', $request->get('received_at'));


        $payment->fill($paymentData);
        $payment->save();

        flash('The payment of $' . $payment->amount_paid . ' was updated.')->success();

        return redirect('/admin/payments');
    }

    /**
     * Delete an existing Payment
     *
     * @param Payment $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Payment $payment) {
        $payment->delete();

        flash('The payment of $' . $payment->amount_paid . ' has been deleted.')->success();

        return redirect()->back();
    }
}

