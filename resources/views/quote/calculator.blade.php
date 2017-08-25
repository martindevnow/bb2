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
                            <p>Fill out the form below to determine the cost to convert your pup to the BARF diet!</p>
                            <quotes-calculator></quotes-calculator>

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