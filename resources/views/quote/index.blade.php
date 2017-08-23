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
                            <h1>We are still working on it ... </h1>
                            <p>Our goal is to bring the BARF diet to as many people as we can.</p>
                            <p>To accomplish this, we need time to ensure our online systems are up to the highest standard of quality.
                                As such, we are not able to offer online ordering at this time.</p>
                            <p>If you wish to <b>signup</b> with us, please <a href="/contact">contact us</a> by sending us an email
                                or giving us a call!</p>
                            <p>We look forward to hearing from you!</p>
                            <p>- Vivian Wong</p>

                            {{--<plan-builder></plan-builder>--}}

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