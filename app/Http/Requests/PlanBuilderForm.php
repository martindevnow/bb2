<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\InvoiceItem;

class PlanBuilderForm extends FormRequest
{
    /**
     * Guests are permitted to Checkout
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripeEmail'       => 'required|email',
            'stripeToken'       => 'required',
            'pet_weight'        => 'required|integer',
            'pet_name'          => 'required',
            'pet_breed'         => 'required',
            'package_id'        => 'required',
            'weeks_at_a_time'   => 'required'
        ];
    }

    public function save() {
        $customer = Customer::create([
            'email'     => $this->stripeEmail,
            'source'    => $this->stripeToken,
        ]);

        $package = Package::find($this->package_id);

        $cost = round(Plan::getPrice($this->weight, $package, $this->weeks_at_a_time)
            * 100,
            0);

        $invoiceItem = InvoiceItem::create([
            'customer'  => $customer->id,
            'amount'    => $cost,
            'currency'  => 'cad'
        ]);


    }
}
