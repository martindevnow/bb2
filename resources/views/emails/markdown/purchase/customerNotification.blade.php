@component('mail::message')
# Order Received

Thank you for ordering with {{ config('app.name') }}!
We've received your order and are working on processing it right away!

We will send you an email once your order has been processed and shipped.

# Package Contents

@component('mail::table')
| Item             | Quantity            | Unit Cost             |
| ---------------- |:-------------------:| ---------------------:|
@foreach($order->details as $item)
| {{$item->label}} | {{$item->quantity}} | ${{$item->unit_cost}} |
@endforeach
@endcomponent

# Delivery Address

Your order will be delivered to the following address:

> {{$order->deliveryAddress->name}} <br>
> {{$order->deliveryAddress->street_1}} {{$order->deliveryAddress->street_2 ? ', ' . $order->deliveryAddress->street_2 : '' }} <br>
> {{$order->deliveryAddress->city}}, {{$order->deliveryAddress->province}} <br>
> {{$order->deliveryAddress->country}} <br>
> {{$order->deliveryAddress->postal_code}}


@component('mail::button', ['url' => config('app.url')])
Buy more!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent