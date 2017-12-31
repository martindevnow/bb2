@extends('layouts.material.app')

@section('configuration')
    <?php $showSlider = false; ?>
@endsection

@section('content')

      <div class="container">
      
        <h1 class="right-line mb-4">Checkout - Delivery (Step 1 of 2)</h1>
        <div class="row">

          <div class="col-sm-12 laptop apple">
              <div class="card ms-feature">
                  <div class="card-block text-center">
      Have an account? Save time by <a href="/login">logging in</a>.
                  </div>
              </div>
          </div>

          <div class="col-md-9">

<form action="/cart/update" method="POST">
          {{ csrf_field() }}
          @foreach($cart as $item)
            <div class="card mb-1">
              <table class="table table-responsive table-no-border vertical-center">
                <tbody><tr>
                  <td class="d-none d-sm-block">
                    <img src="assets/img/demo/products/m1.png" alt=""> </td>
                  <td><a href="/treats/{{ $item->model->sku }}">
                    <h4 class="">{{ $item->name}}</h4>
                    </a>
                  </td>
                  <td>
                    <div class="form-inline input-number">
                      <div class="form-group"><input type="text" class="form-control form-control-number" pattern="[0-9]*" value="{{ $item->qty }}" name="products[{{ $item->id }}]"></div> </div>
                  </td>
                  <td>
                    <span class="color-success">${{ number_format($item->price, 2) }} CAD</span>
                  </td>
                  <td class="d-none d-sm-block">
                  <a href="/cart/remove/{{ $item->id }}"
                    <button class="btn btn-danger">
                      <i class="zmdi zmdi-delete"></i> Remove</button>
                  </td>
                </tr>
              </tbody></table>
            </div>
          @endforeach


          @if($cart->count())
            <div class="mb-1" style="height: 70px;">
                <button class="btn btn-primary btn-raised" style="float: right;">Update Quantities</button>
            </div>
          @endif
            
          </div>
</form>

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
                    <span class="color-warning">{{ \Cart::subtotal() > 50 ? "Free" : "$5.25 CAD" }}</span>
                  </li>
                </ul>
                <h3>
                  <strong>Total:</strong>
                  <span class="color-success">${{ number_format(\Cart::subtotal() * 1.13 + (\Cart::subtotal() > 50 ? 0 : 5.25), 2) }} CAD</span>
                </h3>
                <a href="javascript:void(0)" class="btn btn-raised btn-info btn-block btn-raised mt-2 no-mb">
                  <i class="zmdi zmdi-shopping-cart-plus"></i> Checkout</a>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>

@endsection