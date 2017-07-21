@extends('layouts.smartadmin.app')

@section('content')
    <h1>Meals</h1>
    <div class="row">
        {{--<admin-meats-navigator></admin-meats-navigator>--}}

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Code</td>
                <td>Type</td>
                <td>Variety</td>
                <td>Cost Per Pound</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $meat->code }}</td>
                    <td>{{ $meat->type }}</td>
                    <td>{{ $meat->variety }}</td>
                    <td>{{ $meat->cost_per_lb }}</td>
                    <td>
                        <a href="/admin/meats/{{ $meat->id }}/edit">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>
                        <form action="/admin/meats/{{ $meat->id }}" method="POST">
                            <?= csrf_field() ?>
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="meat_id" type="hidden" value="{{ $meat->id }}">
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