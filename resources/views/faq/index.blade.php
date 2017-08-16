@extends('layouts.material.app')

@section('content')

    <div class="ms-hero-page-override ms-hero-img-city" style="background-image: url('/barfbento/img/boiled-tripe.jpg')">
        <div class="container">
            <div class="text-center">
                <h1>&nbsp;</h1>
                {{--<span class="ms-logo ms-logo-lg ms-logo-white center-block mb-2 mt-2 animated zoomInDown animation-delay-5">BB</span>--}}
                {{--<h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">B.A.R.F.--}}
                    {{--<span>Bento</span>--}}
                {{--</h1>--}}
                {{--<p class="lead lead-lg color-white text-center center-block mt-2 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">Enter the compelling--}}
                    {{--<span class="color-warning">motto</span> of B.A.R.F. Bento here!</p>--}}
            </div>
        </div>
    </div>

    <div class="container container-full">
        <div class="card" style="position: relative; top: -100px;">
            <div class="card-block-big">
                <h1 class="color-primary">Frequently Asked Questions</h1>
                <p>Deciding to change your pet's diet is not an easy decision to come to. There are a lot of questions
                    that pet owners commonly ask us. We've done our best to gather the knowledge and information you
                    need to decide the best path for you and your pte. </p>
                <p>We understand that our pets are our family and it's important that we feed them a proper diet.
                    Unfortunately, our pets aren't health conscious and will commonly eat what we put in front of them
                    (or even what they dig out of the garbage!) So, it's up to the owner to ensure they're fed a healthy,
                    well balanced diet.
                </p>
                <p>Please refer to the FAQ listed below in the hopes of understanding the benefits of B.A.R.F., pet nutrition, who we are, our product and our policies.
                    If you still have questions after consulting this page, please don't hesitate to
                    <a href="/contact">reach out to us</a> on the <a href="/contact">contact us</a> page.</p>

                <!-- FAQ -->
                <div class="card nav-tabs-ver-container">
                    <div class="row">
                        <div class="col-md-3">
                            <ul class="nav nav-tabs-ver nav-tabs-ver-primary" role="tablist">
                                @foreach($categories as $index => $category)
                                <li role="presentation" class="{{ $index == 0 ? 'active' : '' }}"><a href="#{{ $category->code }}" aria-controls="home" role="tab" data-toggle="tab"><i class="zmdi"></i> {{ $category->label }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-9 nav-tabs-ver-container-content">
                            <div class="card-block">
                                <div class="tab-content">

                                    @foreach($categories as $index => $category)
                                    <div role="tabpanel" class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $category->code }}">
                                        <div class="panel-group ms-collapse" id="accordion" role="tablist" aria-multiselectable="true">


                                            @foreach($category->faqs as $faqIndex => $faq)
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading-{{ $index }}-{{ $faqIndex }}">
                                                    <h4 class="panel-title ms-rotate-icon">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $index }}-{{ $faqIndex }}" aria-expanded="false" aria-controls="collapse-{{ $index }}-{{ $faqIndex }}">
                                                            <i class="fa fa-question"></i> {{ $faq->question }}
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse-{{ $index }}-{{ $faqIndex }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $index }}-{{ $faqIndex }}">
                                                    <div class="panel-body">
                                                        {!! $faq->answer !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach


                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection