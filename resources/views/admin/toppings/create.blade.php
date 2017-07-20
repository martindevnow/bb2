@extends('layouts.smartadmin.app')

@section('content')

    <h1>Meats: Add</h1>
    <form action="/admin/toppings" method="POST">
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
                           placeholder="Code of the topping"
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
                           placeholder="Label of topping"
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
                    <label for="cost_per_kg">Cost_per_kg:</label>
                    <input type="text"
                           name="cost_per_kg"
                           value="{{ old('cost_per_kg') }}"
                           class="form-control"
                           id="cost_per_kg"
                           aria-describedby="cost_per_kgHelp"
                           placeholder="How much does it cost?"
                           autocomplete="off">
                    @if ($errors->has('cost_per_kg'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cost_per_kg') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="cost_per_kgHelp" class="form-text text-muted">Cost per KG of topping</small>
            </div>

        <button type="submit" class="btn btn-primary" >Add</button>

    </form>


@endsection