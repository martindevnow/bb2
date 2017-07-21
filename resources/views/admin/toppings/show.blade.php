@extends('layouts.smartadmin.app')

@section('content')
    <h1>Meals</h1>
    <div class="row">

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Code</td>
                <td>Type</td>
                <td>Cost Per KG</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $topping->code }}</td>
                    <td>{{ $topping->type }}</td>
                    <td>{{ $topping->cost_per_kg }}</td>
                    <td>
                        <a href="/admin/toppings/{{ $topping->id }}/edit">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                        <form action="/admin/toppings/{{ $topping->id }}" method="POST">
                            <?= csrf_field() ?>
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="topping_id" type="hidden" value="{{ $topping->id }}">
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection