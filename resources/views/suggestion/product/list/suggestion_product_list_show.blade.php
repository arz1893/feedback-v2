@extends('home')

@section('content-header')
    <h3 class="text-orange">Suggestion Detail</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>
            <a href="{{ route('suggestion_product_list.index') }}">
                <i class="fa fa-list"></i> Suggestion Product List
            </a>
        </li>
        <li class="active">Show Detail</li>
    </ol>
@endsection

@section('main-content')
    <div class="col-md-9">
        <div class="box box-warning">
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-read-info">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="{{ asset($suggestionProduct->product->img) }}" width="125px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading text-orange">
                                {{ $suggestionProduct->product->name }} ( {{ $suggestionProduct->product_category->name }} )
                                <span class="mailbox-read-time pull-right">{{ $suggestionProduct->created_at->format('d F Y, H:iA') }}</span>
                            </h4>
                        </div>
                    </div>
                    <h5>From:
                        <span id="reply_to" class="text-info">
                            @if($suggestionProduct->customerId != null)
                                {{ $suggestionProduct->customer->name }} \ <i class="ion ion-android-call"></i> {{ $suggestionProduct->customer->phone }}
                            @else
                                Anonymous
                            @endif
                        </span>
                    </h5>
                </div>
                <!-- /.mailbox-read-info -->

                <div class="mailbox-read-message">
                    <span class="text-muted">Suggestion:</span>
                    <p>{{ $suggestionProduct->customer_suggestion }}</p>
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                @if($suggestionProduct->attachment != null)
                    <span class="text-muted">Attachment:</span>
                    <ul class="mailbox-attachments clearfix">
                        <li>
                            <div id="lightgallery">
                                <a href="{{ asset($suggestionProduct->attachment) }}">
                                    <span class="mailbox-attachment-icon has-img">
                                        <img src="{{ asset($suggestionProduct->attachment) }}" alt="Attachment">
                                    </span>
                                </a>
                            </div>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Attachment</a>
                                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
                <button type="button" class="btn btn-danger" data-id="{{ $suggestionProduct->systemId }}" onclick="deleteSuggestionProduct(this)">
                    <i class="fa fa-trash-o"></i> Delete
                </button>
                <a href="{{ route('suggestion_product_list.edit', $suggestionProduct->systemId) }}" class="btn btn-warning"><i class="ion ion-edit"></i> Edit</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->

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