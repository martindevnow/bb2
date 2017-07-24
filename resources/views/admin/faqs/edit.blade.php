@extends('layouts.smartadmin.app')

@section('content')

    <h1>Meats: Edit</h1>
    <form action="/admin/faqs/{{ $faq->id }}" method="POST">
        <?= csrf_field() ?>
            <input name="_method" type="hidden" value="PUT">

            <div class="form-group">
                <div class="input-group">
                    <label for="code">Code:</label>
                    <input type="text"
                           name="code"
                           value="{{ $faq->code }}"
                           class="form-control"
                           id="code"
                           aria-describedby="codeHelp"
                           placeholder="Code of the faq"
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
                           value="{{ $faq->label }}"
                           class="form-control"
                           id="label"
                           aria-describedby="labelHelp"
                           placeholder="Label of faq"
                           autocomplete="off">
                    @if ($errors->has('label'))
                        <span class="help-block">
                            <strong>{{ $errors->first('label') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="labelHelp" class="form-text text-muted">Label</small>
            </div>


            <div class="form-group">
                <div class="input-group">
                    <label for="question">Question:</label>
                    <input type="text"
                           name="question"
                           value="{{ $faq->question }}"
                           class="form-control"
                           id="question"
                           aria-describedby="questionHelp"
                           placeholder="Question"
                           autocomplete="off">
                    @if ($errors->has('question'))
                        <span class="help-block">
                            <strong>{{ $errors->first('question') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="questionHelp" class="form-text text-muted">What is the question?</small>
            </div>


            <div class="form-group">
                <div class="input-group">
                    <label for="answer">Answer:</label>
                    <input type="text"
                           name="answer"
                           value="{{ $faq->answer }}"
                           class="form-control"
                           id="answer"
                           aria-describedby="answerHelp"
                           placeholder="Answer"
                           autocomplete="off">
                    @if ($errors->has('answer'))
                        <span class="help-block">
                            <strong>{{ $errors->first('answer') }}</strong>
                        </span>
                    @endif
                </div>
                <small id="answerHelp" class="form-text text-muted">What is the answer?</small>
            </div>

        <button type="submit" class="btn btn-primary" >Update</button>

    </form>


@endsection