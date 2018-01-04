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
          @foreach($cart as $item)
                <tr>
                  <td class="d-none d-sm-block">
                    <img src="assets/img/demo/products/m1.png" alt=""> </td>
                  <td><a href="/treats/{{ $item->model->sku }}">
                    <h4 class="">{{ $item->name}}</h4>
                    </a>
                  </td>
                  <td>
                    {{ $item->qty }}
                  </td>
                  <td>
                    <span class="color-success">${{ number_format($item->price, 2) }} CAD</span>
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


        @if($cart->count())
          <div class="col-md-3">
            <div class="card card-primary">
              <div class="card-header">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Summary</div>
              <div class="card-block">
                <ul class="list-unstyled">
                  <li>
                    <strong>Price: </strong> ${{ number_format(\Cart::subtotal(), 2) }} CAD</li>
                  <li>
                    <strong>Tax: </strong> ${{ number_format(\Cart::subtotal() * .13, 2) }} CAD</li>
                  <li>
                    <strong>Shipping costs: </strong>
                    <span class="color-warning">{{ \Cart::subtotal() >= 50 ? "Free" : "$5.25 CAD" }}</span>
                  </li>
                </ul>
                <h3>
                  <strong>Total:</strong>
                  <span class="color-success">${{ number_format((\Cart::subtotal() + (\Cart::subtotal() >= 50 ? 0 : 5.25)) * 1.13, 2) }} CAD</span>
                </h3>

                <form action="/checkout/complete" method="POST">
                {{ csrf_field() }}
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="{{ config('services.stripe.key') }}"
    data-amount="{{ round((\Cart::subtotal() + (\Cart::subtotal() >= 50 ? 0 : 5.25)) * 1.13 * 100) }}"
    data-name="BARFBento Treats"
    data-description="All natural treats for your pup."
    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    data-locale="auto"
    data-zip-code="false">
  </script>
</form>
                <a href="/checkout" class="btn btn-raised btn-info btn-block btn-raised mt-2 no-mb">
                  <i class="zmdi zmdi-shopping-cart-plus"></i> Pay Now</a>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>

@endsection