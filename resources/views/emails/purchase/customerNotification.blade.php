<h2>Thank you for your order</h2>

<h3>Order Contents:</h3>
<ul>
    @foreach($order->details as $detail)
    <li>{{ $detail->label }} x {{ $detail->quantity }}</li>
    @endforeach
</ul>

<h3>Delivery Address</h3>
<p>{{ $order->deliveryAddress->toString() }}</p>

<h4>Thank you</h4>
<h3>BARFBento Staff</h3>