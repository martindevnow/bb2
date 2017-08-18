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
                        <h1 class="color-primary">Quote</h1>
                        <section class="ms-component-section">
                            <div class="alert alert-info">
                                <p>
                                    <i class="zmdi zmdi-info-outline"></i> Simply fill out the fields below to get your
                                    <strong>quote</strong> to being the B.A.R.F. diet</p>
                            </div>

                            <form class="form-horizontal">
                                <fieldset>
                                    <h2 class="section-title">Fill in all fields</h2>
                                    Coming soon.

                                    <plan-builder></plan-builder>
                                </fieldset>
                            </form>
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