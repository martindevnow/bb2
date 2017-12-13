<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\InvoiceItem;
use Stripe\Subscription;

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
            'package_id'        => 'required|exists:packages,id',
            'shipping_modifier' => 'required',
        ];
    }

    public function save() {
        $customer = Customer::create([
            'email'     => $this->stripeEmail,
            'source'    => $this->stripeToken,
        ]);

        $package = Package::find($this->package_id);

        $cost = round(Plan::getPrice($this->pet_weight, $package, $this->shipping_modifier)
            * 100,
            0);

        $invoiceItem = InvoiceItem::create([
            'description'   => $package->label . ' B.A.R.F.Bento for ' . $this->pet_name,
            'customer'      => $customer->id,
            'amount'        => $cost,
            'currency'      => 'cad'
        ]);

        $subscription = Subscription::create([
            'customer'  => $customer->id,
            'items' => [
                ['plan'  => 'barfbento-master',]
            ]
        ]);

        Log::info('[Customer]');
        Log::info($customer);

        Log::info('[InvoiceItem]');
        Log::info($invoiceItem);

        Log::info('[Subscription]');
        Log::info($subscription);
    }
}
