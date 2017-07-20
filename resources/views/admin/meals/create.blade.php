@extends('layouts.smartadmin.app')

@section('content')

    <h1>Meals: Add</h1>
    <form action="/admin/meals" method="POST">
        <?= csrf_field() ?>

            <div class="form-group">
                <div class="input-group">
                    <label for="code">Code:</label>
                    <input type="text"
                           name="code"
                           value="{{ old('code') }}"
                           class="form-control"
                           id="code"
                           aria-describedby="codeHelp"
                           placeholder="Code of the meal"
                           autocomplete="off">
                    @if ($errors->has('code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('code') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="codeHelp" class="form-text text-muted">Must be unique</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="label">Label:</label>
                    <input type="text"
                           name="label"
                           value="{{ old('label') }}"
                           class="form-control"
                           id="label"
                           aria-describedby="labelHelp"
                           placeholder="Label of meal"
                           autocomplete="off">
                    @if ($errors->has('label'))
                        <span class="help-block">
                            <strong>{{ $errors->first('label') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="labelHelp" class="form-text text-muted">Like, chicken, beef, etc...</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="meal_value">Meal Value:</label>
                    <input type="text"
                           name="meal_value"
                           value="{{ old('meal_value') }}"
                           class="form-control"
                           id="meal_value"
                           aria-describedby="meal_valueHelp"
                           placeholder="Meal Value"
                           autocomplete="off">
                    @if ($errors->has('meal_value'))
                        <span class="help-block">
                            <strong>{{ $errors->first('meal_value') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="meal_valueHelp" class="form-text text-muted">Like, cube, ground, chunk, slice, etc...</small>
            </div>

        <button type="submit" class="btn btn-primary" >Add</button>

    </form>


@endsection