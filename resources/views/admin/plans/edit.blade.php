@extends('layouts.smartadmin.app')

@section('content')

    <div class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false" role="widget">

        <!-- widget options:
        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

        data-widget-colorbutton="false"
        data-widget-editbutton="false"
        data-widget-togglebutton="false"
        data-widget-deletebutton="false"
        data-widget-fullscreenbutton="false"
        data-widget-custombutton="false"
        data-widget-collapsed="true"
        data-widget-sortable="false"

        -->

        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
            <span class="widget-icon"> <i class="fa fa-check txt-color-white"></i> </span>
            <h2> Plans </h2>
            <!-- <div class="widget-toolbar">
            add: non-hidden - to disable auto hide

            </div>-->
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">

                <form action="/admin/plans/{{ $plan->id }}" method="POST">
                    <header>
                        Edit the Plan for : {{ $plan->pet->name }}
                    </header>
                    <?= csrf_field() ?>
                    <input name="_method" type="hidden" value="PUT">

                    <fieldset>

                        <section class="col col-6">
                            <label class="label" for="pet_id">Pet:</label>
                            <label class="select">
                                <select class="form-control"
                                        id="pet_id"
                                        name="pet_id"
                                        aria-describedby="pet_idHelp"
                                >
                                    @foreach($pets as $pet)
                                        <option value="{{ $pet->id }}"
                                                {{ $plan->pet_id === $pet->id ? 'selected="selected"' : '' }}
                                        >
                                            {{ $pet->name }} ({{ $pet->owner->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                            <small id="pet_idHelp" class="form-text text-muted">The owner of this pet.</small>
                        </section>

                        <section class="col col-6">
                            <label class="label" for="package_id">Package:</label>
                            <label class="select">
                                <select class="form-control"
                                        id="package_id"
                                        name="package_id"
                                        aria-describedby="package_idHelp"
                                >
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}"
                                                {{ $plan->package_id === $package->id ? 'selected="selected"' : '' }}
                                        >
                                            {{ $package->label }} ({{ $package->id }})
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            @if ($errors->has('package_id'))
                                <span class="help-block">
                            <strong>{{ $errors->first('package_id') }}</strong>
                        </span>
                            @endif
                            <small id="package_idHelp" class="form-text text-muted">The package.</small>
                        </section>

                        <section class="col col-6">
                            <label class="label" for="shipping_cost">Shipping Cost:</label>
                            <label class="input">
                                <input type="text"
                                       name="shipping_cost"
                                       value="{{ $plan->shipping_cost }}"
                                       class="form-control"
                                       id="shipping_cost"
                                       aria-describedby="shipping_costHelp"
                                       placeholder="shipping_cost"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('shipping_cost'))
                                <span class="help-block">
                            <strong>{{ $errors->first('shipping_cost') }}</strong>
                        </span>
                            @endif
                            <small id="shipping_costHelp" class="form-text text-muted">The shipping cost to this person.</small>
                        </section>


                        <section class="col col-6">
                            <label class="label" for="weekly_cost">Weekly Cost:</label>
                            <label class="input">
                                <input type="text"
                                       name="weekly_cost"
                                       value="{{ $plan->weekly_cost }}"
                                       class="form-control"
                                       id="weekly_cost"
                                       aria-describedby="weekly_costHelp"
                                       placeholder="weekly_cost"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('weekly_cost'))
                                <span class="help-block">
                            <strong>{{ $errors->first('weekly_cost') }}</strong>
                        </span>
                            @endif
                            <small id="weekly_costHelp" class="form-text text-muted">The weekly cost to this person.</small>
                        </section>


                        <section class="col col-6">
                            <label class="label" for="weeks_at_a_time">Weeks at a Time:</label>
                            <label class="input">
                                <input type="text"
                                       name="weeks_at_a_time"
                                       value="{{ $plan->weeks_at_a_time }}"
                                       class="form-control"
                                       id="weeks_at_a_time"
                                       aria-describedby="weeks_at_a_timeHelp"
                                       placeholder="weeks_at_a_time"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('weeks_at_a_time'))
                                <span class="help-block">
                            <strong>{{ $errors->first('weeks_at_a_time') }}</strong>
                        </span>
                            @endif
                            <small id="weeks_at_a_timeHelp" class="form-text text-muted">The number of weeks to be delivered at a time.</small>
                        </section>

                        <section class="col col-6">
                            <label class="label" for="active">Active</label>
                            <label class="input">
                                <input type="text"
                                       name="active"
                                       value="{{ $plan->active }}"
                                       class="form-control"
                                       id="active"
                                       aria-describedby="activeHelp"
                                       placeholder="active"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('active'))
                                <span class="help-block">
                            <strong>{{ $errors->first('active') }}</strong>
                        </span>
                            @endif
                            <small id="activeHelp" class="form-text text-muted">Whether this Plan is active or not.</small>
                        </section>
                    </fieldset>

                    <footer>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                        <button type="button" class="btn btn-default" onclick="window.history.back();">
                            Back
                        </button>
                    </footer>
                </form>
            </div>
        </div>
    </div>


@endsection