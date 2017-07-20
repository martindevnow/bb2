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
                <td>Average Cost Per Pound</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $meal->code }}</td>
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
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-responsive table-striped table-bordered">
                    <thead>
                    <tr>
                        <td>Meat</td>
                        <td>Cost per lb</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($meats as $meat)
                        <tr>
                            <td>{{ $meat->type }} {{ $meat->variety }} [{{ $meat->code }}]</td>
                            <td>{{ $meat->cost_per_lb }}</td>
                            <td>
                                @if ( ! $meal->hasMeat($meat))
                                    <form action="/admin/meals/{{ $meal->id }}/addMeat" method="POST">
                                        <?= csrf_field() ?>
                                        <input name="_method" type="hidden" value="POST">
                                        <input name="meat_id" type="hidden" value="{{ $meat->id }}">
                                        <button class="btn btn-xs btn-primary"
                                                id="add-meat-id-{{ $meat->id }}"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="/admin/meals/{{ $meal->id }}/removeMeat" method="POST">
                                        <?= csrf_field() ?>
                                        <input name="_method" type="hidden" value="POST">
                                        <input name="meat_id" type="hidden" value="{{ $meat->id }}">
                                        <button class="btn btn-xs btn-danger"
                                                id="remove-meat-id-{{ $meat->id }}"
                                        >
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="col-md-6">

                <table class="table table-responsive table-striped table-bordered">
                    <thead>
                    <tr>
                        <td>Topping</td>
                        <td>Cost Per Kg</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($toppings as $topping)
                        <tr>
                            <td>{{ $topping->label }} [{{ $topping->code }}]</td>
                            <td>{{ $topping->cost_per_kg }}</td>
                            <td>
                                @if (! $meal->hasTopping($topping))
                                    <form action="/admin/meals/{{ $meal->id }}/addTopping" method="POST">
                                        <?= csrf_field() ?>
                                        <input name="_method" type="hidden" value="POST">
                                        <input name="topping_id" type="hidden" value="{{ $topping->id }}">
                                        <button class="btn btn-xs btn-primary"
                                                id="add-topping-id-{{ $topping->id }}"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="/admin/meals/{{ $meal->id }}/removeTopping" method="POST">
                                        <?= csrf_field() ?>
                                        <input name="_method" type="hidden" value="POST">
                                        <input name="topping_id" type="hidden" value="{{ $topping->id }}">
                                        <button class="btn btn-xs btn-danger"
                                                id="remove-topping-id-{{ $topping->id }}"
                                        >
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>


    </div>

@endsection