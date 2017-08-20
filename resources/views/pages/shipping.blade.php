@extends('layouts.material.app')

@section('content')

    <div class="ms-hero-page-override ms-hero-img-city" style="background-image: url('/barfbento/img/yoghurt.jpg')">
        <div class="container">
            <div class="text-center">
                {{--<span class="ms-logo ms-logo-lg ms-logo-white center-block mb-2 mt-2">BB</span>--}} &nbsp;<br><br>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card wow slideInUp" style="visibility: visible; animation-name: slideInUp; position: relative; top: -100px;">
            <div class="card-block-big">
                <h1 class="color-primary">Shipping</h1>
                <p>Right now, we are only servicing the Greater Toronto Area (GTA).</p>
                <p><b>However</b>, we are interested to expand to all of southern Ontario. If you are interested in joining
                B.A.R.F.Bento and you aren't sure whether we'd be able to deliver to you, please <a href="/contact">reach out to us</a>
                to find out if our shipping policy has changed.</p>

            </div>
        </div>
    </div>

@endsection