@extends('home')

@push('scripts')
    <script src="{{ asset('js/input-mask/jquery.inputmask.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/input-mask/jquery.inputmask.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/input-mask/jquery.inputmask.date.extensions.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('[data-mask]').inputmask();
        $('.select2').select2();
    </script>
@endpush

@section('content-header')
    <h4>Add User</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home </a></li>
        <li><a href="{{ route('user.index') }}"><i class="ion ion-person"></i> User Management </a></li>
        <li class="active">Add User</li>
    </ol>
@endsection

@section('main-content')
    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Info!</strong> {{ \Session::get('status') }}
        </div>
    @endif

    {{ Form::open(['action' => 'User\UserController@sendInvitation', 'id' => 'form_add_user']) }}
        <div class="col-lg-offset-3">
            @include('layouts.user.user_form')
        </div>
    {{ Form::close() }}
@endsection