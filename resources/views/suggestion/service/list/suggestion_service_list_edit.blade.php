@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue/vue_service.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4>Edit Suggestion Product</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('suggestion_service_list.index') }}"><i class="ion ion-clipboard"></i>Suggestion Service List</a></li>
        <li class="active">Edit Suggestion Service</li>
    </ol>
@endsection

@section('main-content')
    <div class="col-lg-6">
        {{ Form::model($suggestionService, ['method' => 'PATCH', 'action' => ['Suggestion\SuggestionServiceListController@update', $suggestionService], 'id' => 'form_edit_suggestion_service', 'files' => true]) }}
            <div id="vue_service_container">
                @include('layouts.suggestion.service.suggestion_service_form_edit', ['submitButtonText' => 'Update Suggestion Service'])
            </div>
        {{ Form::close() }}
    </div>

    <div class="col-lg-4">
        {{ Form::open(['action' => ['Suggestion\SuggestionServiceListController@changeAttachment', $suggestionService->systemId], 'id' => 'form_change_attachment', 'files' => true]) }}
            <div class="form-group">
                {{ Form::label('attachment', 'Change or add attachment') }}
                {{ Form::file('attachment', ['class' => 'form-control-file', 'accept' => 'image/*', 'onchange' => '$("#form_change_attachment").submit()']) }}
                @if($suggestionService->attachment == null)
                    <p class="help-block">You don't have any attachment yet</p>
                @endif
            </div>
        {{ Form::close() }}

        @isset($suggestionService->attachment)
            <span class="text-muted">Current Attachment :</span>
            <ul class="mailbox-attachments clearfix">
                <li>
                    <div id="lightgallery">
                        <a href="{{ asset($suggestionService->attachment) }}">
                    <span class="mailbox-attachment-icon has-img">
                        <img src="{{ asset($suggestionService->attachment) }}" alt="Attachment">
                    </span>
                        </a>
                    </div>

                    <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Attachment</a>
                        <a href="#!" class="btn btn-danger btn-xs pull-right" data-toggle="modal" data-target="#modal_delete_attachment"><i class="fa fa-close"></i></a>
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
                {{ Form::open(['action' => 'Suggestion\SuggestionServiceListController@deleteAttachment']) }}
                {{ Form::hidden('suggestionServiceId', $suggestionService->systemId) }}
                <div class="modal-body">
                    Are you sure want to delete this attachment ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @include('customer.manage_customer')
@endsection
