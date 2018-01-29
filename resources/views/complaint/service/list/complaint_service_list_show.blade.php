@push('scripts')
    <script src="{{ asset('js/vue/vue_service.js') }}" type="text/javascript"></script>
@endpush

@extends('home')

@section('content-header')
    <h3>Complaint Detail</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_service_list.index') }}"><i class="fa fa-list"></i>Complaint Service List</a></li>
        <li class="active">Show Detail</li>
    </ol>
@endsection

@section('main-content')

    <div id="complaint_service_list_show">
        @if(\Session::has('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ \Session::get('status') }}
            </div>
        @endif

        <div class="col-lg-10">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="{{ asset($complaintService->service->img) }}" width="100px" height="75px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading text-danger">{{ $complaintService->service->name }} ( {{ $complaintService->service_category->name }} ) <span class="mailbox-read-time pull-right">{{ $complaintService->created_at->format('d F Y, H:iA') }}</span></h4>
                        </div>
                    </div>
                    <h5>From:
                        <span id="reply_to" class="text-info">
                            @if($complaintService->customerId != null)
                                {{ $complaintService->customer->name }} \ <i class="ion ion-android-call"></i> {{ $complaintService->customer->phone }}
                            @else
                                Anonymous
                            @endif
                        </span>
                    </h5>
                    Satisfaction :
                    @switch($complaintService->customer_rating)
                        @case(1)
                        <button class="btn btn-link">
                            <i class="material-icons text-maroon" style="font-size: 2em;">
                                sentiment_very_dissatisfied
                            </i>
                        </button>
                        @break
                        @case(2)
                        <button class="btn btn-link">
                            <i class="material-icons text-red" style="font-size: 2em;">
                                sentiment_dissatisfied
                            </i>
                        </button>
                        @break
                        @case(3)
                        <button class="btn btn-link">
                            <i class="smiley_rating material-icons text-yellow" style="font-size: 2em;">
                                sentiment_neutral
                            </i>
                        </button>
                        @break
                        @case(4)
                        <button class="btn btn-link">
                            <i class="smiley_rating material-icons text-olive" style="font-size: 2em;">
                                sentiment_satisfied
                            </i>
                        </button>
                        @break
                        @case(5)
                        <button class="btn btn-link">
                            <i class="smiley_rating material-icons text-green" style="font-size: 2em;">
                                sentiment_very_satisfied
                            </i>
                        </button>
                        @break
                    @endswitch
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="mailbox-read-message">
                        <h5 class="text-navy">Complaint: </h5>
                        <p>{{ $complaintService->customer_complaint }}</p>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.box-body -->

                <!-- /.box-footer -->
                <div class="box-footer">

                    @if($complaintService->attachment != null)
                        <span class="text-muted">Attachment : </span>
                        <ul class="mailbox-attachments clearfix">
                            <li>
                                <div id="lightgallery">
                                    <a href="{{ asset($complaintService->attachment) }}">
                                        <span class="mailbox-attachment-icon has-img">
                                            <img src="{{ asset($complaintService->attachment) }}" alt="Attachment">
                                        </span>
                                    </a>
                                </div>

                                <div class="mailbox-attachment-info">
                                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> attachment</a>
                                    <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                </div>
                            </li>
                        </ul>
                    @endif

                    <div class="pull-right">
                        <button v-on:click="showReplyBox($event)" type="button" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Reply</button>
                        <button type="button" class="btn btn-sm btn-default"><i class="fa fa-share"></i> Forward</button>
                    </div>
                    <button type="button"
                            class="btn btn-sm btn-danger"
                            data-id="{{ $complaintService->systemId }}"
                            onclick="deleteComplaintService(this)"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Delete">
                        <i class="fa fa-trash-o"></i> Delete
                    </button>
                    <a href="{{ route('complaint_service_list.edit', $complaintService->systemId) }}" class="btn btn-sm btn-warning"><i class="ion ion-edit"></i> Edit</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->

        <div class="col-lg-10" id="reply_box" v-if="showReply == true">
            <div class="box box-danger">
                {{ Form::open(['action' => 'Complaint\ComplaintServiceReplyController@store']) }}
                {{ Form::hidden('customerId', $complaintService->customer->systemId) }}
                {{ Form::hidden('complaintServiceId', $complaintService->systemId) }}
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <span>Reply to : </span> <span v-html="replyTo"></span>
                    </div>
                    <div class="form-group">
                        <textarea id="reply_content"
                                  name="reply_content"
                                  class="form-control"
                                  placeholder="Reply. . ."
                                  rows="6">
                        </textarea>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                </div>
                <!-- /.box-footer -->
                {{ Form::close() }}
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->


        <!-- Modal Remove Complaint -->
        <div class="modal fade" id="modal_remove_complaint_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-danger" id="myModalLabel">Add Complaint</h4>
                    </div>
                    {{ Form::open(['action' => 'Complaint\ComplaintServiceListController@deleteComplaintService', 'id' => 'form_delete_complaint_service']) }}

                    <div class="modal-body">
                        Are you sure want to delete this complaint ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Remove Complaint</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection