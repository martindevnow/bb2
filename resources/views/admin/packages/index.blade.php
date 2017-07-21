@extends('layouts.smartadmin.app')

@section('content')
    <h1>Packages: All</h1>

    <a href="/admin/packages/create">
        <button class="btn btn-block btn-primary">
            <i class="fa fa-wrench"></i> Create New
        </button>
    </a>
    <div class="row">

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Code</td>
                <td>Label</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($packages as $package)
                <tr>
                    <td><a href="/admin/packages/{{ $package->id }}">{{ $package->code }}</a></td>
                    <td>{{ $package->label }}</td>
                    <td>
                        <a href="/admin/packages/{{ $package->id }}/edit">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>

                        <form action="/admin/packages/{{ $package->id }}" method="POST">
                            <?= csrf_field() ?>
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="package_id" type="hidden" value="{{ $package->id }}">
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