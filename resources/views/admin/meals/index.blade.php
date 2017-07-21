@extends('layouts.smartadmin.app')

@section('content')
    <h1>Meals: All</h1>
    <div class="row">
        {{--<admin-meals-navigator></admin-meals-navigator>--}}
        <a href="/admin/meals/create">
            <button class="btn btn-block btn-primary">
                <i class="fa fa-wrench"></i> Create New
            </button>
        </a>

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Code</td>
                <td>Label</td>
                <td>Meal Value</td>
                <td>Avg Cost / lb</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($meals as $meal)
                <tr>
                    <td><a href="/admin/meals/{{ $meal->id }}">{{ $meal->code }}</a></td>
                    <td>{{ $meal->label }}</td>
                    <td>{{ $meal->meal_value }}</td>
                    <td>{{ $meal->costPerLb() }}</td>
                    <td>
                        <a href="/admin/meals/{{ $meal->id }}/edit">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                        
                        <form action="/admin/meals/{{ $meal->id }}" method="POST">
                            <?= csrf_field() ?>
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="meal_id" type="hidden" value="{{ $meal->id }}">
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


    </div>

@endsection