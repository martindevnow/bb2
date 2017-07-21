<div class="schedule-day-title">Day {{ $day }}</div>
<div class="schedule-day-breakfast">
        <admin-meals-select-box day="{{ $day }}B"
                                label="Breakfast"
                                package_id="{{ $package->id }}"
                                :meals="{{ $meals }}"
                                :defaultMeal="{{ $package->hasMeal($day . 'B')
                                        ? $package->getMeal($day . 'B')->toJson()
                                        : '' }}"
        >

        </admin-meals-select-box>
</div>
<div class="schedule-day-dinner">
        <admin-meals-select-box day="{{ $day }}D"
                                label="Dinner"
                                package_id="{{ $package->id }}"
                                :meals="{{ $meals }}"
                                :defaultMeal="{{ $package->hasMeal($day . 'D')
                                        ? $package->getMeal($day . 'D')->toJson()
                                        : '' }}"
        >
        </admin-meals-select-box>
</div>