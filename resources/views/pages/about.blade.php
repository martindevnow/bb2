@extends('layouts.material.app')

@section('content')

    <div class="ms-hero-page-override ms-hero-img-city" style="background-image: url('/barfbento/img/yoghurt.jpg')">
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
        <div class="card wow slideInUp" style="visibility: visible; animation-name: slideInUp; position: relative; top: -80px;">
            <div class="card-block-big">
                <h1 class="color-primary">About Us</h1>
                <p>We're just like you. We're pet owners who became concerned with what we've been feeding our pets. We recognize our pets as a part of our family and we came to realize that we need to take the same time, care and effort to ensure that
                    our pets can live a long and healthy life. In our own lives, we took this mission to heart and did the research required to understand what was in the "kibbles" we had once called "food" for our dogs. And after realizeing the truth of
                    what exactly these foods contain, we set out to find the right path.</p>

            </div>
            {{--<img src="/material/img/demo/team.jpg" alt="" class="img-responsive">--}}
            <div class="card-block-big">
                <h2 class="color-primary">Vision</h2>
                <p>Learning about the <strong>B.A.R.F. Diet</strong> truely opened our eyes as to what is important in your pet's diet. It points you in the most natural and addative-free direction by bringing their diet in alignment with their biology.
                    As loving humans, even while wanting what's best for our pets, we often forget that our pets biology is quite different from ours. We've met many concerned pet owners who feed their animals the healthy home cooked meals that they serve
                    their human offspring. While on the right path and with the best intentions, it still somewhat misses the mark. It seemed to us that the biggest problem was the lack of knowledge and availability of a well-balanced meal plan that kept most
                    people in the dark about proper pet nutrition. This is where B.A.R.F.Bento comes in.</p>
                <p class="lead"> Established in 2016, we set out with the mission <strong>to enable pet owners to feed their pets a truly health diet</strong> in the hopes of affecting as many lives as possible.</p>
                <p>This mission has guided
                    us to educating our friends and family on the B.A.R.F. diet and slowly on-boarding people we met at the dog park. But now we want to increase our impact to increase the vitality and longevity of our furry friends.</p>
                <p>So, join our wolf pack. Get on the B.A.R.F.Bento diet and watch our fuzzy family members smiling faces when they are fed a proper, healthy diet: free from hormones, anti-biotics and other preservatives and additives.</p>
            </div>
        </div>
    </div>


    <section class="">
        <div class="container card">
            <div class="text-center">
                <h1 class="color-primary">Dogs of B.A.R.F. Bento</h1>
                <p class="lead lead-lg color-medium">Get inspired with our best work</p>
            </div>
            <div class="row">
                @foreach($pics as $pic)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="ms-thumbnail-container wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <figure class="ms-thumbnail">
                            <img src="{{ $pic->images->standard_resolution->url }}" alt="" class="img-responsive">
                            <figcaption class="ms-thumbnail-caption text-center">
                                <div class="ms-thumbnail-caption-content">
                                    {{--<h3 class="ms-thumbnail-caption-title">Lorem ipsum dolor sit</h3>--}}
                                    <p>{{ substr($pic->caption->text, 0, 300) }} {{ strlen($pic->caption->text) > 300 ? '...' : '' }}</p>
                                    <a href="{{ $pic->link }}" class="btn btn-white btn-raised color-primary">
                                        <i class="zmdi zmdi-eye"></i> View more</a>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection