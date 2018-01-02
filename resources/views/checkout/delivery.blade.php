@extends('layouts.material.app')

@section('configuration')
    <?php $showSlider = false; ?>
@endsection

@section('content')

      <div class="container">
      
        <h1 class="right-line mb-4">Checkout - Delivery (Step 1 of 2)</h1>
        <div class="row">

          <div class="col-md-12 laptop apple">
              <div class="card ms-feature">
                  <div class="card-block text-center">
      Have an account? Save time by <a href="/login">logging in</a>.
                  </div>
              </div>
          </div>

          <div class="col-md-9">

              @auth
<form action="/checkout/member" method="POST">
          {{ csrf_field() }}

            <div class="card mb-1">
              <table class="table table-responsive table-no-border vertical-center">
                <tbody>
                <tr>
                    <td>
                        <select>
                            <option>15 Carousel Circle</option>
                            <option>503 Beecroft Road</option>
                        </select>
                    </td>
                </tr>
              </tbody></table>
            </div>
</form>
              @endauth


              @guest


    <div class="card card-primary">
        <div class="card-header">
            <i class="fa fa-list-alt" aria-hidden="true"></i> Delivery Address</div>
        <div class="card-block">
            <form action="/checkout/guest" method="POST">
                {{ csrf_field() }}
                <table class="table table-responsive table-no-border vertical-center">
                    <tr>
                        <td>
                            <input type="text" name="name" placeholder="Recipient" /><br />
                            <input type="text" name="street_1" placeholder="Street" /><br />
                            <input type="text" name="street_2" placeholder="Street (cont)" /><br />
                            <input type="text" name="city" placeholder="City "/><br />
                            <input type="text" name="province" placeholder="Province "/><br />
                            <input type="text" name="postal_code" placeholder="Postal Code" /><br />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-info btn-raised">Continue</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
              @endguest

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
                  <span class="color-success">${{ number_format(\Cart::subtotal() * 1.13 + (\Cart::subtotal() >= 50 ? 0 : 5.25), 2) }} CAD</span>
                </h3>
                {{--<a href="javascript:void(0)" class="btn btn-raised btn-info btn-block btn-raised mt-2 no-mb">--}}
                  {{--<i class="zmdi zmdi-shopping-cart-plus"></i> Checkout</a>--}}
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>

@endsection