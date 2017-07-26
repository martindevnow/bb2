@extends('layouts.smartadmin.app')

@section('content')

    <h1>Pets: Edit</h1>
    <form action="/admin/pets/{{ $pet->id }}" method="POST">
        <?= csrf_field() ?>
            <input name="_method" type="hidden" value="PUT">

            <div class="form-group">
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text"
                           name="name"
                           value="{{ $pet->name }}"
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
                           value="{{ $pet->weight }}"
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
                           value="{{ $pet->activity_level }}"
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
                           value="{{ $pet->species }}"
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
                           value="{{ $pet->breed }}"
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
                           value="{{ $pet->birthday }}"
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

        <button type="submit" class="btn btn-primary" >Update</button>

    </form>


@endsection