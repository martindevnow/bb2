@extends('layouts.smartadmin.app')

@section('content')
    <h1>Toppings: All</h1>
    <div class="row">
        <a href="/admin/faqs/create">
            <button class="btn btn-block btn-primary">
                <i class="fa fa-wrench"></i> Create New
            </button>
        </a>

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Code</td>
                <td>Label</td>
                <td>Question</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($faq_categories as $faq_category)
                <tr><td colspan="5">{{ $faq_category->label }} - ({{ $faq_category->code }})</td></tr>
                @foreach($faq_category->faqs as $faq)
                <tr>
                    <td>{{ $faq->code }}</td>
                    <td>{{ $faq->label }}</td>
                    <td>{{ $faq->question }}</td>
                    <td>{{ $faq->answer }}</td>
                    <td>
                        <a href="/admin/faqs/{{ $faq->id }}/edit">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>

                        <form action="/admin/faqs/{{ $faq->id }}" method="POST">
                            <?= csrf_field() ?>
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="faq_id" type="hidden" value="{{ $faq->id }}">
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>


    </div>

@endsection