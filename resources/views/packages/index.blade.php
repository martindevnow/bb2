@extends('layouts.material.app')

@section('content')

    <div class="material-background"></div>
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="uppercase color-white animated fadeInUp animation-delay-7">See our packages</h2>
            <p class="lead uppercase color-medium animated fadeInUp animation-delay-7">Surprise with our unique features</p>
        </div>
        <div class="row">
            <div class="col-md-4 price-table price-table-info animated zoomInDown animation-delay-7">
                <header class="price-table-header">
                    <span class="price-table-category">Basic</span>
                    <h3>
                        <sup>$</sup>10
                        <sub>/wk.</sub>
                    </h3>
                </header>
                <div class="price-table-body">
                    <ul class="price-table-list">
                        <li>
                            <i class="zmdi zmdi-code"></i> Lorem ipsum dolor sit amet.</li>
                        <li>
                            <i class="zmdi zmdi-globe"></i> Voluptate ex quam autem. Dolor.</li>
                        <li>
                            <i class="zmdi zmdi-settings"></i> Dignissimos velit reiciendis cumque.</li>
                        <li>
                            <i class="zmdi zmdi-cloud"></i> Nihil corrupti soluta vitae non.</li>
                        <li>
                            <i class="zmdi zmdi-star"></i> Atque molestiae, blanditiis ratione.</li>
                    </ul>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="btn btn-info btn-raised">
                            <i class="zmdi zmdi-cloud-download"></i> Get Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 price-table price-table-success prominent animated zoomInUp animation-delay-7">
                <header class="price-table-header">
                    <span class="price-table-category">Classic</span>
                    <h3>
                        <sup>$</sup>12
                        <sub>/wk.</sub>
                    </h3>
                </header>
                <div class="price-table-body">
                    <ul class="price-table-list">
                        <li>
                            <i class="zmdi zmdi-code"></i> Lorem ipsum dolor sit amet.</li>
                        <li>
                            <i class="zmdi zmdi-globe"></i> Voluptate ex quam autem. Dolor.</li>
                        <li>
                            <i class="zmdi zmdi-settings"></i> Dignissimos velit reiciendis cumque.</li>
                        <li>
                            <i class="zmdi zmdi-cloud"></i> Nihil corrupti soluta vitae non.</li>
                        <li>
                            <i class="zmdi zmdi-star"></i> Atque molestiae, blanditiis ratione.</li>
                    </ul>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="btn btn-success btn-raised">
                            <i class="zmdi zmdi-cloud-download"></i> Get Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 price-table price-table-warning animated zoomInDown animation-delay-7">
                <header class="price-table-header">
                    <span class="price-table-category">Premium</span>
                    <h3>
                        <sup>$</sup>14
                        <sub>/wk.</sub>
                    </h3>
                </header>
                <div class="price-table-body">
                    <ul class="price-table-list">
                        <li>
                            <i class="zmdi zmdi-code"></i> Lorem ipsum dolor sit amet.</li>
                        <li>
                            <i class="zmdi zmdi-globe"></i> Voluptate ex quam autem. Dolor.</li>
                        <li>
                            <i class="zmdi zmdi-settings"></i> Dignissimos velit reiciendis cumque.</li>
                        <li>
                            <i class="zmdi zmdi-cloud"></i> Nihil corrupti soluta vitae non.</li>
                        <li>
                            <i class="zmdi zmdi-star"></i> Atque molestiae, blanditiis ratione.</li>
                    </ul>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="btn btn-warning btn-raised">
                            <i class="zmdi zmdi-cloud-download"></i> Get Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
