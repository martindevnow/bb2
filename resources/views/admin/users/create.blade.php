@extends('layouts.smartadmin.app')

@section('content')

    <h1>Users: Add</h1>
    <form action="/admin/users" method="POST">
        <?= csrf_field() ?>

            <div class="form-group">
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control"
                           id="name"
                           aria-describedby="nameHelp"
                           placeholder="Name"
                           autocomplete="off">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="nameHelp" class="form-text text-muted">The user's name.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control"
                           id="email"
                           aria-describedby="emailHelp"
                           placeholder="you@example.com"
                           autocomplete="off">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="emailHelp" class="form-text text-muted">The user's email.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="text"
                           name="password"
                           value="{{ old('password') }}"
                           class="form-control"
                           id="password"
                           aria-describedby="passwordHelp"
                           placeholder=""
                           autocomplete="off">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="passwordHelp" class="form-text text-muted">The user's password.</small>
            </div>

        <button type="submit" class="btn btn-primary">Add</button>

    </form>


@endsection