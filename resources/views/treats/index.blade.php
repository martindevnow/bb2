@extends('layouts.material.app')

@section('configuration')

    <?php $showSlider = false; ?>

@endsection

@section('content')


    <div class="ms-hero-page-override ms-hero-img-city2 ms-hero-bg-info" style="background-image: url('/barfbento/img/trade-show.jpg');">
        <div class="text-center color-white index-1">
            <h1>Treats</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row" id="Container" style="position: relative; top: -100px;">

                    <div class="col-sm-12 laptop apple">
                        <div class="card ms-feature">
                            <div class="card-block text-center">
                                Free shipping on orders over $50!
                            </div>
                        </div>
                    </div>

                    @foreach($treats as $treat)
                    <div class="col-lg-3 col-md-6 col-xs-12 mix laptop apple" data-price="{{ $treat->price }}" data-date="20170901" style="display: inline-block;" data-bound="">
                        <div class="card ms-feature">
                            <div class="card-block text-center">
                                <a href="/treats/{{ $treat->sku }}">
                                    <img src="/barfbento/img/treats/square/{{ $treat->sku }}.jpg" alt="" class="img-responsive center-block">
                                </a>
                                <h4 class="text-normal text-center">{{ $treat->name }} ({{ $treat->size }})</h4>
                                <p>{{ $treat->description }}</p>
                                <div class="mt-2">
                                    <span class="ms-tag ms-tag-success ms-xl">$ {{ $treat->price }}</span>
                                </div>
                                <a href="/cart/add/{{ $treat->id }}" class="btn btn-primary btn-sm btn-block btn-raised mt-2 no-mb">
                                    <i class="zmdi zmdi-shopping-cart-plus"></i> Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

@endsection