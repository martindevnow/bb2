@extends('layouts.smartadmin.app')

@section('content')
    <h1>Packages: Details</h1>
    <div class="row">

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Code</td>
                <td>Label</td>
                <td>Cost Per Lb</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $package->code }}</td>
                    <td>{{ $package->label }}</td>
                    <td>{{ $package->costPerLb() }}</td>
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
            </tbody>
        </table>
    </div>
    <form action="/admin/packages/{{ $package->id }}/updateCalendar" method="POST">
        <div class="row seven-cols">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT" />
                <div class="col-md-1 schedule-day">
                    @include('admin.partials.schedule.day', [
                        'day' => 1,
                    ])
                </div>
                <div class="col-md-1 schedule-day">
                    @include('admin.partials.schedule.day', [
                        'day' => 2,
                    ])
                </div>
                <div class="col-md-1 schedule-day">
                    @include('admin.partials.schedule.day', [
                        'day' => 3,
                    ])
                </div>
                <div class="col-md-1 schedule-day">
                    @include('admin.partials.schedule.day', [
                        'day' => 4,
                    ])
                </div>
                <div class="col-md-1 schedule-day">
                    @include('admin.partials.schedule.day', [
                        'day' => 5,
                    ])
                </div>
                <div class="col-md-1 schedule-day">
                    @include('admin.partials.schedule.day', [
                        'day' => 6,
                    ])
                </div>
                <div class="col-md-1 schedule-day">
                    @include('admin.partials.schedule.day', [
                        'day' => 7,
                    ])
                </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-block btn-primary"
                        type="submit"
                >
                    <i class="fa fa-document"></i> Save Changes
                </button>
            </div>
        </div>
    </form>


@endsection