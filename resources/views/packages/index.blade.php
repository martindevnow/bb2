@extends('layouts.material.app')

@section('content')

    {{--<div class="material-background"></div>--}}
    <div class="ms-hero-page ms-hero-img-city2 ms-hero-bg-info mb-6" style="background-image: url('/barfbento/img/throat.jpg'); padding: 30px 0 140px; margin: -40px 0 0;">
        <div class="text-center color-white mt-6 mb-6 index-1">
            <h1>B.A.R.F.Bento Menu</h1>
            <p class="lead lead-lg">These are the packages that we have available.</p>
            {{--<a href="javascript:void(0)" class="btn btn-raised btn-white color-danger">--}}
            {{--<i class="zmdi zmdi-label"></i> Latest offers</a>--}}
        </div>
    </div>

    <div class="container" style="position: relative; top: -160px;">
        <div class="row">
            <div class="col-md-4 price-table">
                <h3 class="text-center">Basic</h3>
                <div class="card" style="box-shadow: none;">
                    <img src="/barfbento/img/basic.jpg" alt="" class="img-responsive" width="100%">
                    <div class="card-block text-center">
                        <h4 class="color-primary">Basic Bento</h4>
                        <p>Includes two basic protein: <span class="color-primary">chicken & turkey</span>.
                            Recommended for those new to the raw diet or those with sensitive stomachs.
                            Example of meals may include: ground chicken/turkey, ground bone in chicken/turkey; with added coconut and Golgi berries.
                            Customization/substitution is $3 extra per week.</p>
                        {{--<a href="javascript:void(0)" class="btn btn-primary">--}}
                            {{--<i class="zmdi zmdi-star"></i> Learn More</a>--}}
                        <a href="javascript:void(0)" class="btn btn-primary btn-raised">
                            <i class="zmdi zmdi-flower"></i> Subscribe!</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 price-table">
                <h3 class="text-center">Classic</h3>
                <div class="card" style="box-shadow: none;">
                    <img src="/barfbento/img/classic.jpg" alt="" class="img-responsive" width="100%">
                    <div class="card-block text-center">
                        <h4 class="color-primary">Classic Bento</h4>

                        <p>Includes everything in the <span class="color-primary">Basic Bento + 3 extra proteins: pork, beef and fish</span>.
                            This is the most popular plan.
                            Example of meals may include: ground pork, ground beef, salmon sashimi; with added Chia seeds, parsley, and Golgi Berries.
                            Customization/substitution is $3 extra per week.</p>
                        {{--<a href="javascript:void(0)" class="btn btn-primary">--}}
                            {{--<i class="zmdi zmdi-star"></i> Learn More</a>--}}
                        <a href="javascript:void(0)" class="btn btn-primary btn-raised">
                            <i class="zmdi zmdi-flower"></i> Subscribe</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 price-table">
                <h3 class="text-center">Premium</h3>
                <div class="card" style="box-shadow: none;">
                    <img src="/barfbento/img/premium.jpg" alt="" class="img-responsive" width="100%">
                    <div class="card-block text-center">
                        <h4 class="color-primary">Premium Bento</h4>
                        <p>Includes everything in the <span class="color-primary">Classic Bento + whole prey menu and some exotic meat</span>.
                            This plan is recommended for bigger dogs who loves to chew on whole preys including bones.
                            This plan will include occasional fasting.
                            Examples of meals may include: stuffed beef trachea, pig's head, emu necks; with green lipped mussel, turmeric paste.
                            Customization/substitution is $4 extra per week.</p>
                        {{--<a href="javascript:void(0)" class="btn btn-primary">--}}
                            {{--<i class="zmdi zmdi-star"></i> Learn More</a>--}}
                        <a href="javascript:void(0)" class="btn btn-primary btn-raised">
                            <i class="zmdi zmdi-flower"></i> Subscribe</a>
                    </div>
                </div>
            </div>










            {{--<div class="col-md-4 price-table price-table-info animated zoomInDown animation-delay-7">--}}
                {{--<header class="price-table-header">--}}
                    {{--<span class="price-table-category">Basic</span>--}}
                    {{--<h3>--}}
                        {{--<sup>$</sup>10--}}
                        {{--<sub>/wk.</sub>--}}
                    {{--</h3>--}}
                {{--</header>--}}
                {{--<div class="price-table-body">--}}
                    {{--<ul class="price-table-list">--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-code"></i> Lorem ipsum dolor sit amet.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-globe"></i> Voluptate ex quam autem. Dolor.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-settings"></i> Dignissimos velit reiciendis cumque.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-cloud"></i> Nihil corrupti soluta vitae non.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-star"></i> Atque molestiae, blanditiis ratione.</li>--}}
                    {{--</ul>--}}
                    {{--<div class="text-center">--}}
                        {{--<a href="javascript:void(0)" class="btn btn-info btn-raised">--}}
                            {{--<i class="zmdi zmdi-cloud-download"></i> Get Now</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-4 price-table price-table-success prominent animated zoomInUp animation-delay-7">--}}
                {{--<header class="price-table-header">--}}
                    {{--<span class="price-table-category">Classic</span>--}}
                    {{--<h3>--}}
                        {{--<sup>$</sup>12--}}
                        {{--<sub>/wk.</sub>--}}
                    {{--</h3>--}}
                {{--</header>--}}
                {{--<div class="price-table-body">--}}
                    {{--<ul class="price-table-list">--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-code"></i> Lorem ipsum dolor sit amet.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-globe"></i> Voluptate ex quam autem. Dolor.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-settings"></i> Dignissimos velit reiciendis cumque.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-cloud"></i> Nihil corrupti soluta vitae non.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-star"></i> Atque molestiae, blanditiis ratione.</li>--}}
                    {{--</ul>--}}
                    {{--<div class="text-center">--}}
                        {{--<a href="javascript:void(0)" class="btn btn-success btn-raised">--}}
                            {{--<i class="zmdi zmdi-cloud-download"></i> Get Now</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-4 price-table price-table-warning animated zoomInDown animation-delay-7">--}}
                {{--<header class="price-table-header">--}}
                    {{--<span class="price-table-category">Premium</span>--}}
                    {{--<h3>--}}
                        {{--<sup>$</sup>14--}}
                        {{--<sub>/wk.</sub>--}}
                    {{--</h3>--}}
                {{--</header>--}}
                {{--<div class="price-table-body">--}}
                    {{--<ul class="price-table-list">--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-code"></i> Lorem ipsum dolor sit amet.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-globe"></i> Voluptate ex quam autem. Dolor.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-settings"></i> Dignissimos velit reiciendis cumque.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-cloud"></i> Nihil corrupti soluta vitae non.</li>--}}
                        {{--<li>--}}
                            {{--<i class="zmdi zmdi-star"></i> Atque molestiae, blanditiis ratione.</li>--}}
                    {{--</ul>--}}
                    {{--<div class="text-center">--}}
                        {{--<a href="javascript:void(0)" class="btn btn-warning btn-raised">--}}
                            {{--<i class="zmdi zmdi-cloud-download"></i> Get Now</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>

@endsection
