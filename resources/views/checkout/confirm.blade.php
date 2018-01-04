@extends('layouts.material.app')

@section('configuration')
    <?php $showSlider = false; ?>
@endsection

@section('content')

      <div class="container">
        <h1 class="right-line mb-4">Your Order</h1>
        <div class="row">
          <div class="col-md-9">



            <div class="card card-primary">
                <div class="card-header">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> Items</div>
                <div class="card-block">
              <table class="table table-responsive table-no-border vertical-center">
                <tbody>
          @foreach($cart->getContent()->toArray() as $item)
                <tr>
                  <td class="d-none d-sm-block">
                    <img src="assets/img/demo/products/m1.png" alt=""> </td>
                  <td><a href="/treats/{{ $item['attributes']['sku'] }}">
                    <h4 class="">{{ $item['name'] }}</h4>
                    </a>
                  </td>
                  <td>
                    {{ $item['quantity'] }}
                  </td>
                  <td>
                    <span class="color-success">${{ number_format($item['price'], 2) }} CAD</span>
                  </td>
                </tr>
          @endforeach
              </tbody></table>
            </div>
            </div>



            <div class="card card-primary">
                <div class="card-header">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> Delivery Address</div>
                <div class="card-block">
              <table class="table table-responsive table-no-border">
                <tbody>
                <tr>
                  <td>Recipient</td>
                  <td><span class="color-success">{{ $order->deliveryAddress->name }}</span></td>
                </tr>
                <tr>
                  <td>Street</td>
                  <td><span class="color-success">{{ $order->deliveryAddress->street_1 }}{{ $order->deliveryAddress->street_2 ? ', ' . $order->deliveryAddress->street_2 : '' }}</span></td>
                </tr>
                <tr>
                  <td>City</td>
                  <td><span class="color-success">{{ $order->deliveryAddress->city }}</span></td>
                </tr>
                <tr>
                  <td>Province</td>
                  <td><span class="color-success">{{ $order->deliveryAddress->province }}</span></td>
                </tr>
                <tr>
                  <td>Postal Code</td>
                  <td><span class="color-success">{{ $order->deliveryAddress->postal_code }}</span></td>
                </tr>

              </tbody></table>
            </div>
            </div>



          </div>


        @if($cart->getContent()->count())
          <div class="col-md-3">
            <div class="card card-primary">
              <div class="card-header">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Summary</div>
              <div class="card-block">
                <ul class="list-unstyled">
                  <li>
                    <strong>Price: </strong> ${{ number_format($cart->getSubTotal(), 2) }} CAD</li>
                  
                  @foreach($cart->getConditions() as $condition)
                  <li>
                    <strong>{{ $condition->getName() }}: </strong> ${{ number_format($condition->getCalculatedValue($cart->getSubTotal()), 2) }} CAD</li>
                  @endforeach

                </ul>
                <h3>
                  <strong>Total:</strong>
                  <span class="color-success">${{ number_format($cart->getTotal(), 2) }}</span>
                </h3>

<form action="/checkout/complete" method="POST">
{{ csrf_field() }}
<script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="{{ config('services.stripe.key') }}"
    data-amount="{{ round($cart->getTotal() * 100) }}"
    data-name="BARFBento Treats"
    data-description="All natural treats for your pup."
    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    data-locale="auto"
    data-zip-code="false">
  </script>
</form>
              </div>
            </div>
          </div>
          @endif
          
        
        </div>
      </div>

@endsection