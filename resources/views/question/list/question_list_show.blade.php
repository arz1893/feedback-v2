@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('question_list.index') }}"><i class="fa fa-list"></i> Question List</a></li>
        <li class="active">Question Detail</li>
    </ol>
    <h3 class="text-success"> Question Detail </h3>
@endsection

@section('main-content')

@endsection