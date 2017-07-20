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
                    <label for="value">Value:</label>
                    <input type="text"
                           name="value"
                           value="{{ old('value') }}"
                           class="form-control"
                           id="value"
                           aria-describedby="valueHelp"
                           placeholder="Value of meal"
                           autocomplete="off">
                    @if ($errors->has('value'))
                        <span class="help-block">
                            <strong>{{ $errors->first('value') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="valueHelp" class="form-text text-muted">Like, cube, ground, chunk, slice, etc...</small>
            </div>

        <button type="submit" class="btn btn-primary" >Add</button>

    </form>


@endsection