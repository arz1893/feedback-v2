@extends('home')

@section('content-header')
    <h4 class="text-orange"> Master Service </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Service</li>
    </ol>
@endsection

@section('main-content')

    <a href="{{ route('service.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i> Add Service
    </a>
    <br><br>

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> {{ \Session::get('status') }}
        </div>
    @endif

    <table class="table table-hover table-condensed" cellspacing="0" width="100%" id="table_service">
        <thead>
        <tr>
            <th>No.</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Tags</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $counter = 1; @endphp
        @foreach($services as $service)
            <tr>
                <td>{{ $counter }}</td>
                <td>
                    <a href="{{ route('service.show', $service) }}">
                        @if($service->img != null)
                            <img src="{{ asset($service->img) }}" width="75">
                        @else
                            <img src="{{ asset('default-images/no-image.jpg') }}" width="75">
                        @endif
                    </a>
                </td>
                <td><a href="{{ route('service.show', $service) }}">{{ $service->name }}</a></td>
                <td>{{ $service->description }}</td>
                <td>
                    @foreach($service->tags as $tag)
                        <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('service.edit', $service) }}" class="btn btn-warning">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <button type="button"
                            class="btn btn-danger"
                            data-type="service"
                            data-id="{{ $service->systemId }}"
                            onclick="deleteItem(this)">
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
         id="modal_delete_service"
         tabindex="-1"
         role="dialog"
         aria-labelledby="modal_delete_service"
         aria-hidden="true"
         data-type="product"
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
                {{ Form::open(['action' => 'MasterData\ServiceController@deleteService', 'id' => 'form_delete_service']) }}
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