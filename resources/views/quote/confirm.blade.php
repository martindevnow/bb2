@extends('layouts.material.app')

@section('content')

    <div class="ms-hero-page-override ms-hero-img-farm"
         style="background-image: url('/barfbento/img/throat.jpg');">
        <div class="container">
            <div class="text-center">
                <h1>&nbsp;</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="right-line mb-4">Cart</h1>
        <quotes-checkout hash="{{ $hash }}"></quotes-checkout>
    </div>

@endsection