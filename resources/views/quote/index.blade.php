@extends('layouts.material.app')

@section('content')
    <div class="heads" style="background: url(/catalog/img/img02.jpg) center center;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><span>//</span> Quote</h2>
                </div>
            </div>
        </div>
    </div>


    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Quote</div>
                        <div class="panel-body">

                            <div class="row">
                                <packages-list-view></packages-list-view>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection