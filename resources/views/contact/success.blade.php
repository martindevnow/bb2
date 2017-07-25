@extends('layouts.material.app')

@section('content')

    <div class="ms-hero-page-override ms-hero-img-team ms-hero-bg-primary">
        <div class="container">
            <div class="text-center">
                <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">Contact Us</h1>
                <p class="lead lead-lg color-light text-center center-block mt-2 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">
                    Whether you're new to raw, or a seasoned veteran, we'd love to hear from you! We can answer any questions you have about our program and the diet that we feed to our customers.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card card-hero animated fadeInUp animation-delay-7">
            <div class="card-block">

                <h1>Thank you.</h1>

            </div>
        </div>
        <div class="card card-primary">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5">
                    <div class="card-block wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <div class="mb-2">
                            <span class="ms-logo ms-logo-sm mr-1">BB</span>
                            <h3 class="no-m ms-site-title">B.A.R.F.
                                <span>Bento</span>
                            </h3>
                        </div>
                        <address class="no-mb">
                            <p>
                                <i class="color-danger-light zmdi zmdi-pin mr-1"></i> 503 Beecroft Road</p>
                            <p>
                                <i class="color-warning-light zmdi zmdi-map mr-1"></i> Toronto, ON, M2N 0A2</p>
                            <p>
                                <i class="color-info-light zmdi zmdi-email mr-1"></i>
                                <a href="mailto:info@barfbento.com">info@barfbento.com</a>
                            </p>
                            <p>
                                <i class="color-royal-light zmdi zmdi-phone mr-1"></i>+1 647 202 0692 </p>
                            {{--<p>--}}
                                {{--<i class="color-success-light fa fa-fax mr-1"></i>+34 123 456 7890 </p>--}}
                        </address>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7">
                    <iframe width="100%" height="340" src="https://www.google.com/maps/d/u/0/embed?mid=12HuD4sUWj4Kk0yhWsp9-ttJcZN4"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection