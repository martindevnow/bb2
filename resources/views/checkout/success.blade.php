@extends('layouts.material.app')

@section('configuration')
    <?php $showSlider = false; ?>
@endsection

@section('content')

      <div class="container">
        <h1 class="right-line mb-4">Cart</h1>
        <div class="row">
          <div class="col-md-9">



            <div class="card card-primary">
                <div class="card-header">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> Your Cart</div>
                <div class="card-block">
                  <h2>Save your order history?</h2>
                  <p>Do you wish to save your order history? If so, please register for an account today! Reordering will be a breeze!</p>
                  <a href="/register"><button class="btn btn-raised btn-info">Register</button></a>
                </div>
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Your Cart</div>
              <div class="card-block">
                <h2>Thank you!</h2>
                <p>Thank you for your purchase! You will receive an email with all of your purchase details outlined.</p>
                <p>You will receive a follow up email once your package has been shipped.</p>
                <p>Thank you for supporting BARFBento.</p>
              </div>
            </div>

          </div>



          <div class="col-md-3">
            <div class="card card-primary">
              <div class="card-header">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Summary</div>
              <div class="card-block">

                <table class="table table-responsive table-no-border table-tight">
                  <tbody>
                  <tr>
                    <td>Subtotal:</td>
                    <td class="money">${{ number_format(\Cart::subtotal(), 2) }}</td>
                  </tr>
                  <tr>
                    <td>Tax:</td>
                    <td class="money">${{ number_format(\Cart::subtotal() * .13, 2) }}</td>
                  </tr>
                  <tr>
                    <td>Shipping:</td>
                    <td class="money">{{ \Cart::subtotal() >= 50 ? "Free" : "$5.25" }}</td>
                  </tr>
                  <tr>
                    <td>Total:</td>
                    <td class="money">${{ number_format((\Cart::subtotal() + (\Cart::subtotal() >= 50 ? 0 : 5.25)) * 1.13, 2) }}</td>
                  </tr>
                  </tbody>
                </table>

              </div>
            </div>
          </div>

        </div>
      </div>

@endsection