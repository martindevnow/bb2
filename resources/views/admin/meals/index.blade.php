@extends('layouts.smartadmin.app')

@section('content')
    <h1>Meals</h1>
    <div class="row">
        {{--<admin-meals-navigator></admin-meals-navigator>--}}

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
                        <a href="/admin/meals/delete">
                            <button class="btn btn-danger btn-xs">
                                <i class="fa fa-trash"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


    </div>

@endsection