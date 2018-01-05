@extends('home')

@section('content-header')
    <h4>User Management</h4>

    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User Management</li>
    </ol>
@endsection

@section('main-content')
    <a href="{{ route('user.create') }}" class="btn btn-success">
        <i class="ion-person-add"></i> Add User
    </a> <br> <br>

    <table class="table table-striped table-hover" id="table_user" style="width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Group</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @foreach($users as $user)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>
                        <a>{{ $user->name }}</a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->user_group->name }}</td>
                    <td>
                        {!! $user->active == 1 ? '<span class="text-blue">active</span>':'<span class="text-red">inactive</span>' !!}
                    </td>
                    <td>
                        <a href="#!" class="btn btn-warning">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        @if($user->user_group->name != 'Administrator')
                            <button type="button" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection