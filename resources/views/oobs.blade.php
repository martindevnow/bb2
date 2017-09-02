@extends('layouts.oobs')

@section('content')
    [vc_row el_class="schedule2"]
    [vc_column][vc_tta_tabs]

    [vc_tta_section title="BUSINESS" tab_id="1504367686181-e6b54ab4-4709"]
    [hgroup title="Friday September 15th 2017" center_text="yes"]
    @foreach($fridayEvents->whereIn('category', ['business', 'all']) as $event)
        @include('eventItem', ['event'  => $event])
    @endforeach
    [hgroup title="Saturday September 16th 2017" center_text="yes"]
    @foreach($saturdayEvents->whereIn('category', ['business', 'all']) as $event)
        @include('eventItem', ['event'  => $event])
    @endforeach
    [/vc_tta_section]

    [vc_tta_section title="LAW" tab_id="1504367686188-46e48e4d-df98"]
    [hgroup title="Friday September 15th 2017" center_text="yes"]
    @foreach($fridayEvents->whereIn('category', ['law', 'all']) as $event)
        @include('eventItem', ['event'  => $event])
    @endforeach
    [hgroup title="Saturday September 16th 2017" center_text="yes"]
    @foreach($saturdayEvents->whereIn('category', ['law', 'all']) as $event)
        @include('eventItem', ['event'  => $event])
    @endforeach
    [/vc_tta_section]

    [vc_tta_section title="OTHER" tab_id="1504367719417-bef1e85e-fd2c"]

    [hgroup title="Friday September 15th 2017" center_text="yes"]
    @foreach($fridayEvents->whereIn('category', ['other', 'all']) as $event)
        @include('eventItem', ['event'  => $event])
    @endforeach
    <!-- Other == Event 2 == Title Here -->
    <div class="row talk wcs-class wcs-class--filterable wcs-class--visible wcs-class--with-image wcs-class--term-marketing wcs-class--term-id-29 wcs-class--location-hall-b wcs-class--term-id-20 wcs-class--instructor-lucille-williams wcs-class--term-id-28 wcs-class--day-1 wcs-class--time-afternoon" data-wcs-types="marketing" data-wcs-locations="hall-b" data-wcs-instructors="lucille-williams" data-wcs-day="1" data-wcs-time="afternoon">
        <div class="col-xs-12 col-sm-2">
            <div class="time">
                13<span class="wcs-addons--blink">:</span>30 </div>
        </div>
        <div class="col-xs-12 col-sm-10">
            <div class="content-box">
                <div class="trigger">
                    <i class="fa fa-angle-down"></i>
                </div>
                <h4 class="" data-wcs-id="532" data-wcs-timestamp="1504531800" data-wcs-date="Monday, Sep 4, 2017" data-wcs-time-format="24" data-wcs-modal-id="59aad3c599b18" title="IN EVNT THEME YOU CAN EDIT ABSOLUTELY EVERYTHING">
                    <a href="http://www.coffeecreamthemes.com/themes/evnt/wordpress2/class/in-evnt-theme-you-can-edit-absolutely-everything/">IN EVNT THEME YOU CAN EDIT ABSOLUTELY EVERYTHING </a>
                </h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <p class="speaker">
                    <a href="http://www.coffeecreamthemes.com/themes/evnt/wordpress2/speaker/lucille-williams/">Lucille Williams Saltdex inc. </a>
                </p>
                <div class="row hidden-content">
                    <div class="col-sm-3">
                        <a href="http://www.coffeecreamthemes.com/themes/evnt/wordpress2/speaker/lucille-williams/">
                            <img width="150" height="150" src="http://www.coffeecreamthemes.com/themes/evnt/wordpress2/wp-content/uploads/2016/06/speaker14-150x150.jpg" class="img-responsive  img-circle wp-post-image" alt="" srcset="http://www.coffeecreamthemes.com/themes/evnt/wordpress2/wp-content/uploads/2016/06/speaker14-150x150.jpg 150w, http://www.coffeecreamthemes.com/themes/evnt/wordpress2/wp-content/uploads/2016/06/speaker14-300x300.jpg 300w, http://www.coffeecreamthemes.com/themes/evnt/wordpress2/wp-content/uploads/2016/06/speaker14-180x180.jpg 180w, http://www.coffeecreamthemes.com/themes/evnt/wordpress2/wp-content/uploads/2016/06/speaker14-140x140.jpg 140w, http://www.coffeecreamthemes.com/themes/evnt/wordpress2/wp-content/uploads/2016/06/speaker14.jpg 500w" sizes="(max-width: 150px) 100vw, 150px"> </a>
                    </div>
                    <div class="col-sm-9">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas mauris diam, accumsan eu nisi quis, semper interdum metus. Fusce ullamcorper volutpat feugiat. Duis consectetur erat vitae orci porta vehicula.
                            Ut ac velit sed velit fringilla molestie. Nunc lobortis nisl eros, a imperdiet libero tempus eget. Aenean tortor velit, ultrices eu malesuada eget, sagittis ac eros. Integer gravida, dui ut dapibus auctor, tellus lectus aliquam sapien, non pretium velit nibh ut mauris.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    [hgroup title="Saturday September 16th 2017" center_text="yes"]

    [/vc_tta_section]


    [/vc_tta_tabs][/vc_column][/vc_row]



@endsection