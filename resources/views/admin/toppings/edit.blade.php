@extends('layouts.smartadmin.app')

@section('content')

    <h1>Meats: Edit</h1>
    <form action="/admin/meats/{{ $meat->id }}" method="POST">
        <?= csrf_field() ?>
            <input name="_method" type="hidden" value="PUT">

            <div class="form-group">
                <div class="input-group">
                    <label for="code">Code:</label>
                    <input type="text"
                           name="code"
                           value="{{ $meat->code }}"
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
                           value="{{ $meat->type }}"
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
                           value="{{ $meat->variety }}"
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
                           value="{{ $meat->cost_per_lb }}"
                           class="form-control"
                           id="cost_per_lb"
                           aria-describedby="cost_per_lbHelp"
                           placeholder="Cost per pound of meat"
                           autocomplete="off">
                    @if ($errors->has('cost_per_lb'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cost_per_lb') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="cost_per_lbHelp" class="form-text text-muted">How much does this meat cost us?</small>
            </div>

        <button type="submit" class="btn btn-primary" >Update</button>

    </form>


@endsection