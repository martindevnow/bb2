@extends('layouts.material.app')

@section('content')

    {{--<div class="material-background"></div>--}}
    <div class="ms-hero-page ms-hero-img-city2 ms-hero-bg-info mb-6" style="background-image: url('/barfbento/img/throat.jpg'); padding: 30px 0 140px; margin: -40px 0 0;">
        <div class="text-center color-white mt-6 mb-6 index-1">
            <h1>B.A.R.F.Bento Menu</h1>
            <p class="lead lead-lg">Choose from one of the following...</p>
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

                        <a href="/quote" class="btn btn-primary btn-raised">
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

                        <a href="/quote" class="btn btn-primary btn-raised">
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

                        <a href="/quote" class="btn btn-primary btn-raised">
                            <i class="zmdi zmdi-flower"></i> Subscribe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
