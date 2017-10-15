@extends('layouts.material.app')

@section('content')

    <div class="ms-hero-page-override ms-hero-img-farm " style="background-image: url('/barfbento/img/throat.jpg');">
        <div class="container">
            <div class="text-center">
                <h1>&nbsp;</h1>
            </div>
        </div>
    </div>

    <div class="container container-full">
        <div class="ms-paper" style="position: relative; top: -100px;">
            <div class="row">
                <div class="col-md-12 ms-paper-content-container">
                    <div class="ms-paper-content">
                        <h1 class="color-primary">Register</h1>
                        <section class="ms-component-section">
                            <p>To be able to make modifications to your subscription, view your pet's diet and account, you will need to register.</p>
                            <p>Please</p>

                            <div class="row">
                                <div class="col-sm-6">
                                    <auth-login-form cart_hash="{{ $hash }}"></auth-login-form>
                                </div>
                                <div class="col-sm-6">
                                    <auth-registration-form cart_hash="{{ $hash }}"></auth-registration-form>
                                </div>
                            </div>
                        </section>

                    </div>
                    <!-- ms-paper-content -->
                </div>
                <!-- col-md-9 -->
            </div>
            <!-- row -->
        </div>
        <!-- ms-paper -->
    </div>

@endsection