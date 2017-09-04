<div class="row talk wcs-class wcs-class--filterable wcs-class--visible wcs-class--with-image wcs-class--term-design wcs-class--term-id-16 wcs-class--location-hall-c wcs-class--term-id-21 wcs-class--instructor-jane-harmon wcs-class--term-id-23 wcs-class--instructor-josefina-patton wcs-class--term-id-24 wcs-class--day-1 wcs-class--time-afternoon" data-wcs-types="design" data-wcs-locations="hall-c" data-wcs-instructors="jane-harmon,josefina-patton" data-wcs-day="1" data-wcs-time="afternoon">
    <div class="col-xs-12 col-sm-2">
        <div class="time">
            {{ $event->time[0] }}<span class="wcs-addons--blink">:</span>{{ $event->time[1] }} </div>
    </div>
    <div class="col-xs-12 col-sm-10">
        <div class="content-box">
            @if ($event->hasASpeaker() || $event->sponsor_name)
            <div class="trigger">
                <i class="fa fa-angle-down"></i>
            </div>
            @endif

            <h4 class="" data-wcs-id="216" data-wcs-timestamp="1504526400" data-wcs-date="Monday, Sep 4, 2017" data-wcs-time-format="24" data-wcs-modal-id="59aad3c599b18" title="{{ $event->title }}">
                <a href="#">{{ $event->title }} </a>
            </h4>
            <p style="margin-bottom: 0.5rem"><em>{{ $event->location }}</em></p>
            <p style="margin-bottom: 0.5rem">{{ $event->description }}</p>
            @if (!! $event->speaker_name[0])
            <h3 class="hidden-content" style="display: none;">Speaker{{ count($event->speaker_name) > 1 ? '' : 's' }}</h3>

                @foreach ($event->speaker_name as $key => $name)
                <p class="speaker"><a href="{{ $event->getSpeakerLink($key) ?: '#' }}">{{ $event->getSpeakerName($key) }} </a></p>

                @if($event->hasSpeakerImg($key) || !! $event->getSpeakerDescription($key))
                <div class="row hidden-content" style="display: none; margin-top: 0.5rem;">
                    @if($event->hasSpeakerImg($key))
                    <div class="col-sm-3">
                        <a href="{{ $event->getSpeakerLink($key) ?: '#' }}">
                            <img width="150" height="150" src="{{ $event->getSpeakerImg($key) ?: 'http://via.placeholder.com/150x150' }}" class="img-responsive  img-circle wp-post-image" alt="" sizes="(max-width: 150px) 100vw, 150px">
                        </a>
                    </div>
                    @endif
                    <div class="col-sm-9">
                        <p>{{ $event->getSpeakerDescription($key) }}</p>
                    </div>
                </div>
                @endif

                @endforeach

            @endif
            @if ($event->sponsor_name)
            <h3 class="hidden-content" style="display: none;">Presented By</h3>
            <p class="hidden-content" style="display: none; margin: 0.5rem 0;">
                <a href="{{ $event->sponsor_link ?: '#' }}">{{ $event->sponsor_name }} </a> </p>
            <div class="row hidden-content" style="display: none; margin-top: 0.5rem;">
                <div class="col-sm-3">
                    <a href="{{ $event->sponsor_link ?: '#' }}">
                        <img width="150" height="150" src="/wp-content/uploads{{ $event->sponsor_img ?: 'http://via.placeholder.com/150x150' }}" class="img-responsive  img-circle wp-post-image" alt="" sizes="(max-width: 150px) 100vw, 150px"> </a>
                </div>
                <div class="col-sm-9">
                    <p>{{ $event->sponsor_description }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>