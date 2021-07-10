@extends('layouts.material.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="carousel-product" class="ms-carousel ms-carousel-thumb carousel slide animated zoomInUp animation-delay-5" data-ride="carousel" data-interval="0">
                    <div class="card card-block">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="/barfbento/img/treats/square/{{ $treat->sku }}.jpg" alt="..."> </div>
                            <div class="item">
                                <img src="/material/img/demo/products/2.jpg" alt="..."> </div>
                            <div class="item">
                                <img src="/material/img/demo/products/3.jpg" alt="..."> </div>
                            <div class="item">
                                <img src="/material/img/demo/products/4.jpg" alt="..."> </div>
                            <div class="item">
                                <img src="/material/img/demo/products/5.jpg" alt="..."> </div>
                        </div>
                    </div>
                    <!-- Indicators -->
                    <ol class="carousel-indicators carousel-indicators-tumbs carousel-indicators-tumbs-outside">
                        {{--<li data-target="#carousel-product" data-slide-to="0" class="active">--}}
                            {{--<img src="/material/img/demo/products/m1.png" alt=""> </li>--}}
                        {{--<li data-target="#carousel-product" data-slide-to="1">--}}
                            {{--<img src="/material/img/demo/products/m2.png" alt=""> </li>--}}
                        {{--<li data-target="#carousel-product" data-slide-to="2">--}}
                            {{--<img src="/material/img/demo/products/m3.png" alt=""> </li>--}}
                        {{--<li data-target="#carousel-product" data-slide-to="3">--}}
                            {{--<img src="/material/img/demo/products/m4.png" alt=""> </li>--}}
                        {{--<li data-target="#carousel-product" data-slide-to="4">--}}
                            {{--<img src="/material/img/demo/products/m5.png" alt=""> </li>--}}
                    </ol>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card animated zoomInDown animation-delay-5">
                    <div class="card-block">
                        <h2>{{ $treat->name }} ({{ $treat->size }})</h2>
                        <div class="mb-2 mt-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <span class="mr-2">
                                        <i class="zmdi zmdi-hc-lg zmdi-star color-warning"></i>
                                        <i class="zmdi zmdi-hc-lg zmdi-star color-warning"></i>
                                        <i class="zmdi zmdi-hc-lg zmdi-star color-warning"></i>
                                        <i class="zmdi zmdi-hc-lg zmdi-star color-warning"></i>
                                        <i class="zmdi zmdi-hc-lg zmdi-star"></i>
                                    </span>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <h2 class="color-success no-m text-normal">$ {{ number_format($treat->price, 2) }} CAD</h2>
                                </div>
                            </div>
                        </div>
                        <p class="lead">{{ $treat->description }}</p>
                        <ul class="list-unstyled">
                            @if (!! $treat->description_long)
                            <li><strong>Description: </strong>{{ $treat->description_long }}</li>
                            @endif

                            @if (!! $treat->ingredients)
                            <li><strong>Ingredients: </strong>{{ $treat->ingredients }}</li>
                            @endif

                            @if (!! $treat->benefits)
                            <li><strong>Benefits: </strong>
                                <ul>
                                    @foreach(preg_split( '/\r\n|\r|\n/', $treat->benefits ) as $benefit)
                                        <li>{{ $benefit }}</li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif

                            @if (!! $treat->storage)
                                <li><strong>Storage: </strong>{{ $treat->storage }}</li>
                            @endif

                            <!-- <li>
                                <strong>Number of items: </strong>
                                <div class="form-inline input-number">
                                    <button class="btn-circle btn-circle-primary btn-circle-xs" type="button">
                                        <i class="zmdi zmdi-minus"></i>
                                    </button>
                                    <div class="form-group"><input type="text" class="form-control form-control-number" pattern="[0-9]*" value="1"></div>
                                    <button class="btn-circle btn-circle-primary btn-circle-xs" type="button">
                                        <i class="zmdi zmdi-plus"></i>
                                    </button>
                                </div>
                            </li> -->
                            <li class="mb-2">
                                <strong>Availability: </strong>
                                <span class="ms-tag ms-tag-success">in stock</span>
                            </li>
                            <!-- <li>
                                <strong>Shipping costs: </strong>
                                <span class="color-warning">Free</span>
                            </li> -->
                        </ul>
                        <a href="/cart/add/{{ $treat->id }}" class="btn btn-primary btn-block btn-raised mt-2 no-mb">
                            <i class="zmdi zmdi-shopping-cart-plus"></i> Add to Cart<div class="ripple-container"></div></a>
                    </div>
                </div>
                {{--<div class="card card-success animated fadeInUp animation-delay-10">--}}
                    {{--<div class="card-block text-center">--}}
                        {{--<i class="fa fa-5x mr-2 fa-cc-paypal" aria-hidden="true"></i>--}}
                        {{--<i class="fa fa-5x mr-2 fa-cc-visa" aria-hidden="true"></i>--}}
                        {{--<i class="fa fa-5x mr-2 fa-cc-mastercard" aria-hidden="true"></i>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

@endsection