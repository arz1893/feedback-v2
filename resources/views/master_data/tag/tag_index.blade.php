@extends('home')

@section('content-header')
    <h4> Master Tag </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tag</li>
    </ol>
@endsection

@section('main-content')
    <a href="{{ route('tag.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i> Add Tag
    </a>
    <br><br>

    <table class="table table-bordered table-striped table-responsive" id="table_tags" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Is default?</th>
                <th>Color</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection