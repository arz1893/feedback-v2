@extends('home')

@section('content-header')
    <h4 class="text-danger"> Master Product </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Product</li>
    </ol>
@endsection

@section('main-content')

    <a href="{{ route('product.create') }}" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i> Add Product
    </a>
    <br><br>

    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> {{ \Session::get('status') }}
        </div>
    @endif

    <table class="table table-bordered table-hover table-responsive" cellspacing="0" width="100%" id="table_product">
        <thead>
        <tr>
            <th>No.</th>
            <th>Image</th>
            <th>Name</th>
            <th>Tags</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $counter = 1; @endphp
        @foreach($products as $product)
            <tr>
                <td>{{ $counter }}</td>
                <td>
                    @if($product->img != null)
                        <a href="{{ route('product.show', $product) }}"><img src="{{ asset($product->img) }}" style="max-width: 75px; max-height: 50px;"></a>
                    @else
                        <a href="{{ route('product.show', $product) }}"><img src="{{ asset('default-images/no-image.jpg') }}" style="max-width: 75px; max-height: 50px;"></a>
                    @endif
                </td>
                <td><a href="{{ route('product.show', $product) }}">{{ $product->name }}</a></td>
                <td>
                    @foreach($product->tags as $tag)
                        <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('product.edit', $product) }}" class="btn btn-warning">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <button
                            class="btn btn-danger"
                            data-type="product"
                            data-id="{{ $product->systemId }}"
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
         id="modal_delete_product"
         tabindex="-1"
         role="dialog"
         aria-labelledby="modal_delete_product"
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
                {{ Form::open(['action' => 'MasterData\ProductController@deleteProduct', 'id' => 'form_delete_product']) }}
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