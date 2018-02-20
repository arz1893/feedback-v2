@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_product.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4>Complaint Detail</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_product_list.index') }}"><i class="fa fa-list"></i>Complaint Product List</a></li>
        <li class="active">Show Detail</li>
    </ol>
@endsection

@section('main-content')
    <div id="complaint_product_list_show">
        @if(\Session::has('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ \Session::get('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-10">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="{{ asset($complaintProduct->product->img) }}" width="125px">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading text-danger">
                                    {{ $complaintProduct->product->name }} ( {{ $complaintProduct->product_category->name }} )
                                    <span class="mailbox-read-time pull-right visible-lg visible-md">{{ $complaintProduct->created_at->format('d F Y, H:iA') }}</span>
                                    <span class="mailbox-read-time visible-sm visible-xs">{{ $complaintProduct->created_at->format('d F Y, H:iA') }}</span>
                                </h4>
                            </div>
                        </div>
                        <div>From:
                            <span id="reply_to" class="text-info">
                            @if($complaintProduct->customerId != null)
                                    {{ $complaintProduct->customer->name }} \ <i class="ion ion-android-call"></i> {{ $complaintProduct->customer->phone }}
                                @else
                                    Anonymous
                                @endif
                            </span>
                        </div>
                        <div>
                            Created by :
                            <span class="text-blue"> {{ $complaintProduct->created_by->name }} </span>
                        </div>
                        <span class="text-muted">Satisfaction :</span>
                        @switch($complaintProduct->customer_rating)
                            @case(1)
                            <button class="btn btn-link">
                                <i class="material-icons text-maroon" style="font-size: 2.5em;">
                                    sentiment_very_dissatisfied
                                </i>
                            </button>
                            @break
                            @case(2)
                            <button class="btn btn-link">
                                <i class="material-icons text-red" style="font-size: 2.5em;">
                                    sentiment_dissatisfied
                                </i>
                            </button>
                            @break
                            @case(3)
                            <button class="btn btn-link">
                                <i class="smiley_rating material-icons text-yellow" style="font-size: 2.5em;">
                                    sentiment_neutral
                                </i>
                            </button>
                            @break
                            @case(4)
                            <button class="btn btn-link">
                                <i class="smiley_rating material-icons text-olive" style="font-size: 2.5em;">
                                    sentiment_satisfied
                                </i>
                            </button>
                            @break
                            @case(5)
                            <button class="btn btn-link">
                                <i class="smiley_rating material-icons text-green" style="font-size: 2.5em;">
                                    sentiment_very_satisfied
                                </i>
                            </button>
                            @break
                        @endswitch
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-read-message">
                            <h5 class="text-muted">Complaint: </h5>
                            <p>{{ $complaintProduct->customer_complaint }}</p>
                            @if($complaintProduct->attachment != null)
                                <span class="text-muted">Attachment : </span>
                                <ul class="mailbox-attachments clearfix">
                                    <li style="width: 150px;">
                                        <div id="lightgallery">
                                            <a href="{{ asset($complaintProduct->attachment) }}">
                                                <span class="mailbox-attachment-icon has-img">
                                                    <img src="{{ asset($complaintProduct->attachment) }}" alt="Attachment">
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
                        </div>
                        <!-- /.mailbox-read-message -->

                        <button type="button"
                                class="btn btn-sm btn-danger"
                                data-id="{{ $complaintProduct->systemId }}"
                                onclick="deleteComplaintProduct(this)"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Delete">
                            <i class="fa fa-trash-o"></i> Delete
                        </button>
                        <a href="{{ route('complaint_product_list.edit', $complaintProduct->systemId) }}" class="btn btn-sm btn-warning"><i class="ion ion-edit"></i> Edit</a>
                        <div class="pull-right">
                            @isset($complaintProduct->customer->systemId)
                                <button v-on:click="showReplyBox($event)" type="button" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Reply</button>
                                @else
                                <button disabled type="button" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Cannot reply on anonymous">
                                    <i class="fa fa-reply"></i> Reply
                                </button>
                            @endisset
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <!-- /.box-footer -->
                    <div class="box-footer" id="reply_box" v-if="showReply == true">
                        {{ Form::open(['action' => 'Complaint\ComplaintProductReplyController@store', 'id' => 'form_complaint_product_reply']) }}
                        @isset($complaintProduct->customer->systemId)
                            {{ Form::hidden('customerId', $complaintProduct->customer->systemId) }}
                        @endisset
                        {{ Form::hidden('complaintProductId',$complaintProduct->systemId) }}

                        <div class="form-group">
                            {{ Form::label('reply_content', 'Reply :') }}
                            <div class="form-group" v-bind:class="{'has-error': errors.has('reply_content')}">
                                <textarea id="reply_content"
                                          name="reply_content"
                                          class="form-control"
                                          placeholder="Content. . ."
                                          rows="6"
                                          v-validate="'required'">
                                </textarea>
                                <span class="help-block text-red" v-show="errors.has('reply_content')">
                                    @{{ errors.first('reply_content') }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" @click="submitReply()" class="btn btn-primary pull-right"><i class="fa fa-envelope-o"></i> Send</button>
                            <button type="reset" @click="showReply = false" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                        </div>

                        {{ Form::close() }}
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>

        <h4>
            <a data-toggle="collapse" href="#collapseReply" aria-expanded="false" aria-controls="collapseReply">
                <i class="fa fa-chevron-right"></i> View All Replies
            </a>
        </h4>
        <div class="collapse" id="collapseReply">
            <div class="well col-lg-10 col-md-7 col-sm-12">
                @if(count($complaintProductReplies) == 0)
                    <span class="text-danger">This complaint doesn't have any replies yet</span>
                @endif
                @isset($complaintProductReplies)
                    @php $counter = 1; @endphp
                    @foreach($complaintProductReplies as $complaintProductReply)
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <strong>
                                    {{ $complaintProductReply->created_by->name }} ({{ $complaintProductReply->created_by->user_group->name }})
                                </strong>
                            </div>
                            <div class="panel-body">
                                <p>{{ $complaintProductReply->reply_content }}</p>
                                <button class="btn btn-sm btn-danger"
                                        data-id="{{ $complaintProductReply->systemId }}"
                                        @click="deleteReply($event)">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                                <button class="btn btn-sm btn-warning">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button>
                            </div><!-- /panel-body -->
                            <div class="panel-footer">
                            <span class="text-muted">
                                Replied at {{ $complaintProductReply->created_at->format('d F Y H:iA') }}
                            </span>
                            </div>
                        </div><!-- /panel panel-default -->
                        @php $counter++; @endphp
                    @endforeach
                @endisset
            </div>
        </div>

        <!-- Modal Remove Complaint -->
        <div class="modal fade" id="modal_remove_complaint_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-danger" id="myModalLabel">Add Complaint</h4>
                    </div>
                    {{ Form::open(['action' => 'Complaint\ComplaintProductListController@deleteComplaintProduct', 'id' => 'form_delete_complaint_product']) }}

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

        <!-- Modal Remove Complaint -->
        <div class="modal fade" id="modal_remove_complaint_product_reply" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-danger" id="myModalLabel">Remove Complaint</h4>
                    </div>
                    {{ Form::open(['action' => 'Complaint\ComplaintProductReplyController@deleteReply', 'id' => 'form_delete_complaint_product_reply']) }}
                    <div v-html="replyId"></div>
                    <div class="modal-body">
                        Are you sure want to delete this reply ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Remove Reply</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
@endsection