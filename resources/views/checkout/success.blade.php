@extends('layouts.material.app')

@section('configuration')
    <?php $showSlider = false; ?>
@endsection

@section('content')

      <div class="container">
        <h1 class="right-line mb-4">Order Completed</h1>
        <div class="row">
          <div class="col-md-9">


            @include('flash::message')

            @guest
            <div class="card card-primary">
                <div class="card-header">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> Sign Up?</div>
                <div class="card-block">
                  <h2>Save your order history?</h2>
                  <p>Do you wish to save your order history? If so, please register for an account today! Reordering will be a breeze!</p>
                  <a href="/register"><button class="btn btn-raised btn-info">Register</button></a>
                </div>
            </div>
            @endguest

            <div class="card card-primary">
              <div class="card-header">
                <i class="fa fa-list-alt" aria-hidden="true"></i> Success</div>
              <div class="card-block">
                <h2>Thank you!</h2>
                <p>Thank you for your purchase! You will receive an email with all of your purchase details outlined.</p>
                <p>You will receive a follow up email once your package has been shipped.</p>
                <p>Thank you for supporting BARFBento.</p>
              </div>
            </div>

          </div>


        </div>
      </div>

@endsection