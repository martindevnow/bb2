@extends('layouts.smartadmin.app')

@section('content')
    <h1>Meats</h1>
    <div class="row">
        {{--<admin-meats-navigator></admin-meats-navigator>--}}

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Code</td>
                <td>Type</td>
                <td>Variety</td>
                <td>Cost (per lb)</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($meats as $meat)
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
                        <a href="/admin/meats/delete">
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