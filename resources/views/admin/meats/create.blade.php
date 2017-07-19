@extends('layouts.smartadmin.app')

@section('content')

    <h1>Meats: Add</h1>
    <form action="/admin/meats" method="POST">
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
                           placeholder="Code of the meat"
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
                    <label for="type">Type:</label>
                    <input type="text"
                           name="type"
                           value="{{ old('type') }}"
                           class="form-control"
                           id="type"
                           aria-describedby="typeHelp"
                           placeholder="Type of meat"
                           autocomplete="off">
                    @if ($errors->has('type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="typeHelp" class="form-text text-muted">Like, chicken, beef, etc...</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="variety">Variety:</label>
                    <input type="text"
                           name="variety"
                           value="{{ old('variety') }}"
                           class="form-control"
                           id="variety"
                           aria-describedby="varietyHelp"
                           placeholder="Variety of meat"
                           autocomplete="off">
                    @if ($errors->has('variety'))
                        <span class="help-block">
                            <strong>{{ $errors->first('variety') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="varietyHelp" class="form-text text-muted">Like, cube, ground, chunk, slice, etc...</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="cost_per_lb">Cost_per_lb:</label>
                    <input type="text"
                           name="cost_per_lb"
                           value="{{ old('cost_per_lb') }}"
                           class="form-control"
                           id="cost_per_lb"
                           aria-describedby="cost_per_lbHelp"
                           placeholder="How much does it cost?"
                           autocomplete="off">
                    @if ($errors->has('cost_per_lb'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cost_per_lb') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="cost_per_lbHelp" class="form-text text-muted">Cost per pound of meat</small>
            </div>

        <button type="submit" class="btn btn-primary" >Add</button>

    </form>


@endsection