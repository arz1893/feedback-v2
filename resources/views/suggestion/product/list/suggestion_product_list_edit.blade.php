@push('scripts')
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue/vue_product.js') }}" type="text/javascript"></script>
@endpush

@extends('home')

@section('content-header')
    <h4>Edit Suggestion Product</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('suggestion_product_list.index') }}"><i class="ion ion-clipboard"></i>Suggestion Product List</a></li>
        <li class="active">Edit Suggestion Product</li>
    </ol>
@endsection

@section('main-content')
    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    <div class="col-lg-6">
        {{ Form::model($suggestionProduct, ['method' => 'PATCH', 'action' => ['Suggestion\SuggestionProductListController@update', $suggestionProduct], 'id' => 'form_edit_suggestion_product', 'files' => true]) }}
            <div id="vue_product_container">
                @include('layouts.suggestion.product.suggestion_product_form_edit', ['submitButtonText' => 'Update Suggestion Product'])
            </div>
        {{ Form::close() }}
    </div>

    <div class="col-lg-4">
        {{ Form::open(['action' => ['Suggestion\SuggestionProductListController@changeAttachment', $suggestionProduct->systemId], 'id' => 'form_change_attachment', 'files' => true]) }}
            <div class="form-group">
                {{ Form::label('attachment', 'Change or add attachment') }}
                {{ Form::file('attachment', ['class' => 'form-control-file', 'accept' => 'image/*', 'onchange' => '$("#form_change_attachment").submit()']) }}
                @if($suggestionProduct->attachment == null)
                    <p class="help-block">You don't have any attachment yet</p>
                @endif
            </div>
        {{ Form::close() }}
        @isset($suggestionProduct->attachment)
            <span class="text-muted">Current Attachment :</span>
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
                        <a href="#!" class="btn btn-danger btn-xs pull-right" data-toggle="modal" data-target="#modal_delete_attachment">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                </li>
            </ul>
        @endisset
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_delete_attachment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-red" id="myModalLabel">Alert!</h4>
                </div>
                {{ Form::open(['action' => 'Suggestion\SuggestionProductListController@deleteAttachment']) }}
                    {{ Form::hidden('suggestionProductId', $suggestionProduct->systemId) }}
                    <div class="modal-body">
                        Are you sure want to delete this attachment ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @include('customer.manage_customer')
@endsection
