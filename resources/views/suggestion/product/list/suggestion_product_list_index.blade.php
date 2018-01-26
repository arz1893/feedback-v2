@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Suggestion Product List</li>
    </ol>
@endsection

@section('main-content')
    <h3 class="text-orange">Suggestion Product List</h3>

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    <table class="table table-striped table-bordered table-responsive" id="table_suggestion_product" style="width: 100%">
        <thead>
        <tr>
            <th>No.</th>
            <th>Suggestion</th>
            <th>Created At</th>
            <th>Customer Name</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $counter = 1; @endphp
        @foreach($suggestionProducts as $suggestionProduct)
            <tr>
                <td>{{ $counter }}</td>
                <td>
                    <a href="{{ route('suggestion_product_list.show', $suggestionProduct->systemId) }}">
                        {{ $suggestionProduct->customer_suggestion }}
                    </a>
                </td>
                <td>{{ $suggestionProduct->created_at->format('d-M-Y') }}</td>
                <td>
                    <a>
                        @if($suggestionProduct->customerId != null)
                            {{ $suggestionProduct->customer->name }}
                        @else
                            Anonymous
                        @endif
                    </a>
                </td>
                <td>{{ $suggestionProduct->product->name }}</td>
                <td>{{ $suggestionProduct->product_category->name }}</td>
                <td>
                    @if(Auth::user()->user_group->name == 'Administrator' || Auth::user()->user_group->name == 'Management')
                        <a href="#!"
                           class="btn btn-primary"
                           data-toggle="tooltip"
                           data-placement="bottom"
                           title="Answer">
                            <i class="fa fa-phone"></i>
                        </a>
                        <a href="{{ route('suggestion_product_list.edit', $suggestionProduct->systemId) }}" class="btn btn-warning">
                            <i class="ion ion-edit"></i>
                        </a>
                        <button class="btn btn-danger" data-id="{{ $suggestionProduct->systemId }}" onclick="deleteSuggestionProduct(this)">
                            <i class="ion ion-ios-trash"></i>
                        </button>
                    @else
                        <span class="text-red">Not Authorized</span>
                    @endif
                </td>
            </tr>
            @php $counter++; @endphp
        @endforeach
        </tbody>
    </table>

    <!-- Modal Remove Suggestion -->
    <div class="modal fade" id="modal_remove_suggestion_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">Add Complaint</h4>
                </div>
                {{ Form::open(['action' => 'Suggestion\SuggestionProductListController@deleteSuggestionProduct', 'id' => 'form_delete_suggestion_product']) }}

                <div class="modal-body">
                    Are you sure want to delete this complaint ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Remove Suggestion</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection