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
            <h2> Pets </h2>
            <!-- <div class="widget-toolbar">
            add: non-hidden - to disable auto hide

            </div>-->
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content">

            <div class="widget-body no-padding smart-form">

                <form action="/admin/pets" method="POST">
                    <header>
                        Create a Pet:
                    </header>
                    <?= csrf_field() ?>

                    <fieldset>
                        <section class="col col-6">
                            <label for="owner_id">Owner:</label>
                            <label class="select">
                                <select class="form-control"
                                        id="owner_id"
                                        name="owner_id"
                                        aria-describedby="nameHelp"
                                >
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                            {{ old('owner_id') === $customer->id ? 'selected="selected"' : '' }}
                                    >
                                        {{ $customer->name }} ({{ $customer->id }})
                                    </option>
                                    @endforeach
                                </select>
                            </label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                            <small id="nameHelp" class="form-text text-muted">The owner of this pet.</small>
                        </section>

                        <section class="col col-6">
                            <label for="name">Name:</label>
                            <label class="input">
                                <input type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="form-control"
                                       id="name"
                                       aria-describedby="nameHelp"
                                       placeholder="Name"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                            <small id="nameHelp" class="form-text text-muted">The pet's name.</small>
                        </section>

                        <section class="col col-6">
                            <label for="weight">Weight:</label>
                            <label class="input">
                                <input type="text"
                                       name="weight"
                                       value="{{ old('weight') }}"
                                       class="form-control"
                                       id="weight"
                                       aria-describedby="weightHelp"
                                       placeholder="Weight"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('weight'))
                                <span class="help-block">
                            <strong>{{ $errors->first('weight') }}</strong>
                        </span>
                            @endif
                            <small id="weightHelp" class="form-text text-muted">The pet's weight.</small>
                        </section>

                        <section class="col col-6">
                            <label for="activity_level">Activity level:</label>
                            <label class="input">
                                <input type="text"
                                       name="activity_level"
                                       value="{{ old('activity_level') }}"
                                       class="form-control"
                                       id="activity_level"
                                       aria-describedby="activity_levelHelp"
                                       placeholder="Activity level"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('activity_level'))
                                <span class="help-block">
                            <strong>{{ $errors->first('activity_level') }}</strong>
                        </span>
                            @endif
                            <small id="activity_levelHelp" class="form-text text-muted">The pet's activity_level.</small>
                        </section>

                        <section class="col col-6">
                            <label for="species">Species:</label>
                            <label class="input">
                                <input type="text"
                                       name="species"
                                       value="{{ old('species') }}"
                                       class="form-control"
                                       id="species"
                                       aria-describedby="speciesHelp"
                                       placeholder="Species"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('species'))
                                <span class="help-block">
                            <strong>{{ $errors->first('species') }}</strong>
                        </span>
                            @endif
                            <small id="speciesHelp" class="form-text text-muted">The pet's species.</small>
                        </section>

                        <section class="col col-6">
                            <label for="breed">Breed:</label>
                            <label class="input">
                                <input type="text"
                                       name="breed"
                                       value="{{ old('breed') }}"
                                       class="form-control"
                                       id="breed"
                                       aria-describedby="breedHelp"
                                       placeholder="Breed"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('breed'))
                                <span class="help-block">
                            <strong>{{ $errors->first('breed') }}</strong>
                        </span>
                            @endif
                            <small id="breedHelp" class="form-text text-muted">The pet's breed.</small>
                        </section>

                        <section class="col col-6">
                            <label for="birthday">Birthday:</label>
                            <label class="input">
                                <input type="text"
                                       name="birthday"
                                       value="{{ old('birthday') }}"
                                       class="form-control"
                                       id="birthday"
                                       aria-describedby="birthdayHelp"
                                       placeholder="Birthday"
                                       autocomplete="off">
                            </label>
                            @if ($errors->has('birthday'))
                                <span class="help-block">
                            <strong>{{ $errors->first('birthday') }}</strong>
                        </span>
                            @endif
                            <small id="birthdayHelp" class="form-text text-muted">The pet's birthday.</small>
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