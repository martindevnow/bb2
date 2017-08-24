<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Stripe\Charge;
use Stripe\Customer;

class PlanBuilderForm extends FormRequest
{
    /**
     * Guests are permitted to Checkout
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripeEmail'   => 'required|email',
            'stripeToken'   => 'required',
            'weight'        => 'required|integer',
            'name'          => 'required',
            'breed'         => 'required',
        ];
    }

    public function save() {
        $customer = Customer::create([
            'email'     => $this->stripeEmail,
            'source'    => $this->stripeToken,
        ]);

        $customer = Charge::create([
            'customer'  => $customer->id,
            'amount'    => 2500,
            'currency'  => 'cad',
        ]);

        $this->user()->activate($customer->id);
    }
}
