@extends('layouts.material.app')

@section('content')

    <div class="ms-hero-page-override ms-hero-img-farm " style="background-image: url('/barfbento/img/throat.jpg');">
        <div class="container">
            <div class="text-center">
                <h1>&nbsp;</h1>
            </div>
        </div>
    </div>

    <div class="container container-full">
        <form action="camera" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input id="photo" name="photo" type="file" accept="image/*">
            <button type="submit" class="btn btn-primary">Post</button>
        </form>
    </div>

@endsection