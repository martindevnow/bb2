@extends('layouts.smartadmin.app')

@section('content')
    <h1>Toppings</h1>
    <div class="row">
        {{--<admin-toppings-navigator></admin-toppings-navigator>--}}

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Code</td>
                <td>Label</td>
                <td>Cost (per kg)</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($toppings as $topping)
                <tr>
                    <td>{{ $topping->code }}</td>
                    <td>{{ $topping->label }}</td>
                    <td>{{ $topping->cost_per_kg }}</td>
                    <td>
                        <a href="/admin/toppings/{{ $topping->id }}/edit">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                        <a href="/admin/toppings/delete">
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