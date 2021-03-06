@extends('layouts.material.app')

@section('configuration')
    <?php $showSlider = false; ?>
@endsection

@section('content')
@guest
<form action="/checkout/guest" method="POST" class="form-horizontal">
@endguest

@auth
<form action="/checkout/member" method="POST" class="form-horizontal">
@endauth
      {{ csrf_field() }}

      <div class="container">
      
        <h1 class="right-line mb-4">Checkout - Delivery (Step 1 of 2)</h1>
        <div class="row">

        @include('flash::message')

        @guest
          <div class="col-md-12 laptop apple">
              <div class="card ms-feature">
                  <div class="card-block text-center">
      Have an account? Save time by 
      <a href="/checkout/login">logging in</a>.
                  </div>
              </div>
          </div>
        @endguest

          <div class="col-md-9">


              @auth

              <div class="card card-primary">
                  <div class="card-header">
                      <i class="fa fa-list-alt" aria-hidden="true"></i> Delivery Address</div>
                  <div class="card-block">

                      <table class="table table-responsive table-no-border vertical-center">
                        <tbody>
                        <tr>
                            <td>
                                <div class="form-group row justify-content-end is-empty">
                                    <label for="deliveryAddressSelect" class="col-lg-2 control-label">Address</label>
                                    <div class="col-lg-10">
                                        <div class="btn-group bootstrap-select form-control">
                                            <select id="deliveryAddressSelect" class="form-control selectpicker" data-dropup-auto="false" tabindex="-98"
                                                    name="address_id"
                                            >
                                                <option>Select...</option>
                                                @foreach(\Auth::user()->addresses as $address)
                                                <option value="{{ $address->id }}">{{ $address->toString() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group row justify-content-end">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <a href="/checkout/new-address">
                                            <button type="button" class="btn btn-raised btn-warning">
                                                <i class="fa fa-plus"></i>
                                                Add a new address
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group row justify-content-end">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="submit" class="btn btn-raised btn-info">Continue</button>
                                        <button type="button" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                      </tbody></table>
                  </div>
            </div>
</form>
              @endauth


              @guest


    <div class="card card-primary">
        <div class="card-header">
            <i class="fa fa-list-alt" aria-hidden="true"></i> Delivery Address</div>
        <div class="card-block">

                    <fieldset>
                      <legend>Details</legend>

                      <div class="form-group row is-empty">
                        <label for="inputName" autocomplete="false" class="col-lg-2 control-label">Recipient</label>
                        <div class="col-lg-10">
                        <input type="text" class="form-control" id="inputName" placeholder="Name" autocomplete="off" style="cursor: auto;" name="name" value="{{ old('name') }}"> </div>
                      </div>
                      @if ($errors->has('name'))
                      <div class="alert alert-primary" role="alert">
                        <strong><i class="zmdi zmdi-notifications"></strong></i> {{ $errors->get('name')[0] }} </div>
                      @endif

                      <div class="form-group row is-empty">
                        <label for="inputStreet1" autocomplete="false" class="col-lg-2 control-label">Street</label>
                        <div class="col-lg-10">
                          <input type="text" class="form-control" id="inputStreet1" placeholder="Street" autocomplete="off" style="cursor: auto;" name="street_1" value="{{ old('street_1') }}"> </div>
                      </div>
                      @if ($errors->has('street_1'))
                      <div class="alert alert-primary" role="alert">
                        <strong><i class="zmdi zmdi-notifications"></strong></i> {{ $errors->get('street_1')[0] }} </div>
                      @endif

                      <div class="form-group row is-empty">
                        <label for="inputStreet2" autocomplete="false" class="col-lg-2 control-label"></label>
                        <div class="col-lg-10">
                          <input type="text" class="form-control" id="inputStreet2" placeholder="Street (cont..)" autocomplete="off" style="cursor: auto;" name="street_2" value="{{ old('street_2') }}"> </div>
                      </div>
                      @if ($errors->has('street_2'))
                      <div class="alert alert-primary" role="alert">
                        <strong><i class="zmdi zmdi-notifications"></strong></i> {{ $errors->get('street_2')[0] }} </div>
                      @endif

                      <div class="form-group row is-empty">
                        <label for="inputCity" autocomplete="false" class="col-lg-2 control-label">City</label>
                        <div class="col-lg-10">
                          <input type="text" class="form-control" id="inputCity" placeholder="City" autocomplete="off" style="cursor: auto;" name="city" value="{{ old('city') }}"> </div>
                      </div>
                      @if ($errors->has('city'))
                      <div class="alert alert-primary" role="alert">
                        <strong><i class="zmdi zmdi-notifications"></strong></i> {{ $errors->get('city')[0] }} </div>
                      @endif

                      <div class="form-group row is-empty">
                        <label for="inputProvince" autocomplete="false" class="col-lg-2 control-label">Province</label>
                        <div class="col-lg-10">
                          <input type="text" class="form-control" id="inputProvince" placeholder="Province" autocomplete="off" style="cursor: auto;" name="province" value="{{ old('province') }}"> </div>
                      </div>
                      @if ($errors->has('province'))
                      <div class="alert alert-primary" role="alert">
                        <strong><i class="zmdi zmdi-notifications"></strong></i> {{ $errors->get('province')[0] }} </div>
                      @endif

                      <div class="form-group row is-empty">
                        <label for="inputPostalCode" autocomplete="false" class="col-lg-2 control-label">Postal Code</label>
                        <div class="col-lg-10">
                          <input type="text" class="form-control" id="inputPostalCode" placeholder="Postal Code" autocomplete="off" style="cursor: auto;" name="postal_code" value="{{ old('postal_code') }}"> </div>
                      </div>
                      @if ($errors->has('postal_code'))
                      <div class="alert alert-primary" role="alert">
                        <strong><i class="zmdi zmdi-notifications"></strong></i> {{ $errors->get('postal_code')[0] }} </div>
                      @endif

                      <div class="form-group row justify-content-end">
                        <div class="col-lg-10 col-lg-offset-2">
                          <button type="submit" class="btn btn-raised btn-info">Continue</button>
                          <button type="button" class="btn btn-danger">Cancel</button>
                        </div>
                      </div>

                      
                    </fieldset>
  
        </div>
    </div>
              @endguest

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
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
</form>
@endsection