@extends('layouts.smartadmin.app')

@section('content')

    <h1>FAQs: Add</h1>
    <form action="/admin/faqs" method="POST">
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
                           placeholder="Code"
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
                           placeholder="Label"
                           autocomplete="off">
                    @if ($errors->has('label'))
                        <span class="help-block">
                            <strong>{{ $errors->first('label') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="labelHelp" class="form-text text-muted">What will appear on the website.</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="question">Question:</label>
                    <input type="text"
                           name="question"
                           value="{{ old('question') }}"
                           class="form-control"
                           id="question"
                           aria-describedby="questionHelp"
                           placeholder="Question?"
                           autocomplete="off">
                    @if ($errors->has('question'))
                        <span class="help-block">
                            <strong>{{ $errors->first('question') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="questionHelp" class="form-text text-muted">The question being asked</small>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <label for="answer">Answer:</label>
                    <input type="text"
                           name="answer"
                           value="{{ old('answer') }}"
                           class="form-control"
                           id="answer"
                           aria-describedby="answerHelp"
                           placeholder="Answer?"
                           autocomplete="off">
                    @if ($errors->has('answer'))
                        <span class="help-block">
                            <strong>{{ $errors->first('answer') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="answerHelp" class="form-text text-muted">The answer to the question.</small>
            </div>

        <button type="submit" class="btn btn-primary">Add</button>

    </form>


@endsection