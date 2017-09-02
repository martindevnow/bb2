@extends('layouts.oobs')

@section('content')

    <div class="vc_row wpb_row vc_row-fluid schedule2">
        <div class="wpb_column vc_column_container vc_col-sm-12">
            <div class="vc_column-inner ">
                <div class="wpb_wrapper">
                    <div class="vc_tta-container" data-vc-action="collapse">

                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="presentation" 1="" class="active"><a href="#tab-business" aria-controls="tab-2017-09-04" role="tab" data-toggle="tab" aria-expanded="false">BUSINESS</a></li>
                            <li role="presentation" 2="" class=""><a href="#tab-law" aria-controls="tab-2017-09-05" role="tab" data-toggle="tab" aria-expanded="false">LAW</a></li>
                            <li role="presentation" 3="" class=""><a href="#tab-other" aria-controls="tab-2017-09-06" role="tab" data-toggle="tab" aria-expanded="false">OTHER</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade wcs-timetable__parent wcs-day wcs-day--1 active in" id="tab-business">
                                <div class="section-title headings  text-center">
                                    <h1>Friday September 15th 2017</h1>
                                </div>
                                @foreach($fridayEvents->whereIn('category', ['business', 'all']) as $event)
                                    @include('eventItem', ['event'  => $event])
                                @endforeach
                                <div class="section-title headings  text-center">
                                    <h1>Saturday September 16th 2017</h1>
                                </div>
                                @foreach($saturdayEvents->whereIn('category', ['business', 'all']) as $event)
                                    @include('eventItem', ['event'  => $event])
                                @endforeach
                            </div>


                            <div role="tabpanel" class="tab-pane fade wcs-timetable__parent wcs-day wcs-day--1" id="tab-law">
                                <div class="section-title headings  text-center">
                                    <h1>Friday September 15th 2017</h1>
                                </div>
                                @foreach($fridayEvents->whereIn('category', ['law', 'all']) as $event)
                                    @include('eventItem', ['event'  => $event])
                                @endforeach
                                <div class="section-title headings  text-center">
                                    <h1>Saturday September 16th 2017</h1>
                                </div>
                                @foreach($saturdayEvents->whereIn('category', ['law', 'all']) as $event)
                                    @include('eventItem', ['event'  => $event])
                                @endforeach
                            </div>


                            <div role="tabpanel" class="tab-pane fade wcs-timetable__parent wcs-day wcs-day--1" id="tab-other">
                                <div class="section-title headings  text-center">
                                    <h1>Friday September 15th 2017</h1>
                                </div>
                                @foreach($fridayEvents->whereIn('category', ['other', 'all']) as $event)
                                    @include('eventItem', ['event'  => $event])
                                @endforeach
                                <div class="section-title headings  text-center">
                                    <h1>Saturday September 16th 2017</h1>
                                </div>
                                @foreach($saturdayEvents->whereIn('category', ['other', 'all']) as $event)
                                    @include('eventItem', ['event'  => $event])
                                @endforeach
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection