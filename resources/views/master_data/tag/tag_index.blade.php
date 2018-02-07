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

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> {{ \Session::get('status') }}
        </div>
    @endif

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
        <tbody>
            @php $counter = 1; @endphp
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>
                        <a href="#!">{{ $tag->name }}</a>
                    </td>
                    <td>
                        {!! ($tag->defValue == 1 ? '<span class="text-green">yes</span>':'<span class="text-red">no</span>') !!}
                    </td>
                    <td>
                        <div style="width: 30px; height: 30px; background: {{ $tag->bgColor }}; border-radius: 50%;"></div>
                    </td>
                    <td>
                        <a href="{{ route('tag.edit', $tag->systemId) }}" class="btn btn-warning">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        <button type="button" class="btn btn-danger" data-id="{{ $tag->systemId }}" data-type="tag" onclick="deleteItem(this)">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
                @php $counter++; @endphp
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade"
         id="modal_delete_tag"
         tabindex="-1"
         role="dialog"
         aria-labelledby="modal_delete_tag"
         aria-hidden="true"
         data-type="tag"
         data-id="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title text-danger" id="exampleModalLabel">
                        Alert! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </h3>
                </div>
                {{ Form::open(['action' => 'MasterData\TagController@deleteTag', 'id' => 'form_delete_tag']) }}
                <div class="modal-body">
                    Are you sure want to delete this item ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        Delete <i class="fa fa-trash-o"></i>
                    </button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection