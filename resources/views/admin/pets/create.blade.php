@extends('layouts.smartadmin.app')

@section('content')

    <h1>Pets: Add</h1>
    <form action="/admin/pets" method="POST">
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
                <small id="nameHelp" class="form-text text-muted">The pet's name.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="weight">Weight:</label>
                    <input type="text"
                           name="weight"
                           value="{{ old('weight') }}"
                           class="form-control"
                           id="weight"
                           aria-describedby="weightHelp"
                           placeholder="Weight"
                           autocomplete="off">
                    @if ($errors->has('weight'))
                        <span class="help-block">
                            <strong>{{ $errors->first('weight') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="weightHelp" class="form-text text-muted">The pet's weight.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="activity_level">Activity level:</label>
                    <input type="text"
                           name="activity_level"
                           value="{{ old('activity_level') }}"
                           class="form-control"
                           id="activity_level"
                           aria-describedby="activity_levelHelp"
                           placeholder="Activity level"
                           autocomplete="off">
                    @if ($errors->has('activity_level'))
                        <span class="help-block">
                            <strong>{{ $errors->first('activity_level') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="activity_levelHelp" class="form-text text-muted">The pet's activity_level.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="species">Species:</label>
                    <input type="text"
                           name="species"
                           value="{{ old('species') }}"
                           class="form-control"
                           id="species"
                           aria-describedby="speciesHelp"
                           placeholder="Species"
                           autocomplete="off">
                    @if ($errors->has('species'))
                        <span class="help-block">
                            <strong>{{ $errors->first('species') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="speciesHelp" class="form-text text-muted">The pet's species.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="breed">Breed:</label>
                    <input type="text"
                           name="breed"
                           value="{{ old('breed') }}"
                           class="form-control"
                           id="breed"
                           aria-describedby="breedHelp"
                           placeholder="Breed"
                           autocomplete="off">
                    @if ($errors->has('breed'))
                        <span class="help-block">
                            <strong>{{ $errors->first('breed') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="breedHelp" class="form-text text-muted">The pet's breed.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="birthday">Birthday:</label>
                    <input type="text"
                           name="birthday"
                           value="{{ old('birthday') }}"
                           class="form-control"
                           id="birthday"
                           aria-describedby="birthdayHelp"
                           placeholder="Birthday"
                           autocomplete="off">
                    @if ($errors->has('birthday'))
                        <span class="help-block">
                            <strong>{{ $errors->first('birthday') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="birthdayHelp" class="form-text text-muted">The pet's birthday.</small>
            </div>

        <button type="submit" class="btn btn-primary">Add</button>

    </form>


@endsection