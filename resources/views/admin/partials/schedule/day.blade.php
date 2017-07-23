<div class="schedule-day-title">Day {{ $day }}</div>
<div class="schedule-day-breakfast">
    <div class="form-group">
        <span class="meal-title">Breakfast</span>
        <select class="form-control meal-select"
                id="selected-{{ $day }}B"
                name="selected-{{ $day }}B"
        >
            @if (!$package->hasMeal($day . 'B'))
                <option value="0">Select ...</option>
            @endif
            @foreach ($meals as $meal)
                <option
                        value="{{ $meal->id }}"
                        @if ($package->hasMeal($day . 'B')
                            && $package->getMeal($day . 'B')->id == $meal->id)
                            selected="selected"
                        @endif
                >
                    {{ $meal->label }} ($ {{ $meal->costPerLb()  }})
                </option>
            @endforeach
        </select>
    </div>

        {{--<admin-meals-select-box day="{{ $day }}B"--}}
                                {{--label="Breakfast"--}}
                                {{--package_id="{{ $package->id }}"--}}
                                {{--:preset_meal_id="{{ $package->hasMeal($day . 'B')--}}
                                        {{--? $package->getMeal($day . 'B')->id--}}
                                        {{--: '0' }}"--}}
        {{-->--}}

        {{--</admin-meals-select-box>--}}
</div>
<div class="schedule-day-dinner">
    <div class="form-group">
        <span class="meal-title">Dinner</span>
        <select class="form-control meal-select"
                id="selected-{{ $day }}D"
                name="selected-{{ $day }}D"
        >
            @if (!$package->hasMeal($day . 'D'))
                <option value="0">Select ...</option>
            @endif
            @foreach ($meals as $meal)
                <option
                        value="{{ $meal->id }}"
                        @if ($package->hasMeal($day . 'D')
                            && $package->getMeal($day . 'D')->id == $meal->id)
                        selected="selected"
                        @endif
                >
                    {{ $meal->label }} ($ {{ $meal->costPerLb()  }})
                </option>
            @endforeach
        </select>
    </div>
        {{--<admin-meals-select-box day="{{ $day }}D"--}}
                                {{--label="Dinner"--}}
                                {{--package_id="{{ $package->id }}"--}}
                                {{--:preset_meal_id="{{ $package->hasMeal($day . 'D')--}}
                                        {{--? $package->getMeal($day . 'D')->id--}}
                                        {{--: '0' }}"--}}
        {{-->--}}
        {{--</admin-meals-select-box>--}}
</div>