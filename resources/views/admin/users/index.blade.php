@extends('layouts.smartadmin.app')

@section('content')

    <h1>Users: All</h1>
    <div class="row">
        <a href="/admin/users/create">
            <button class="btn btn-block btn-primary">
                <i class="fa fa-wrench"></i> Create New
            </button>
        </a>

        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <td>Name</td>
                <td>Email</td>
                <td>Pets</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getPets() }}</td>
                    <td>
                        <a href="/admin/users/{{ $user->id }}/edit">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-pencil"></i>
                            </button>
                        </a>

                        <form action="/admin/users/{{ $user->id }}" method="POST">
                            <?= csrf_field() ?>
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="user_id" type="hidden" value="{{ $user->id }}">
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