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
                            <h4 class="media-heading text-danger">{{ $complaintProduct->product->name }} ( {{ $complaintProduct->product_category->name }} ) <span class="mailbox-read-time pull-right">{{ $complaintProduct->created_at->format('d F Y, H:iA') }}</span></h4>
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
                        <h5 class="text-muted">Complaint: </h5>
                        <p>{{ $complaintProduct->customer_complaint }}</p>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.box-body -->

                <!-- /.box-footer -->
                <div class="box-footer">
                    @if($complaintProduct->attachment != null)
                        <span class="text-muted">Attachment : </span>
                        <ul class="mailbox-attachments clearfix">
                            <li>
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
                    <div class="pull-right">
                        <button v-on:click="showReplyBox($event)" type="button" class="btn btn-sm btn-success"><i class="fa fa-reply"></i> Reply</button>
                    </div>
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
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->

        @isset($complaintProductReplies)
            <div class="col-lg-10">
                <h4>View All Replies</h4>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @php $counter = 1; @endphp
                    @foreach($complaintProductReplies as $complaintProductReply)
                        <div class="panel panel-danger">
                            <div class="panel-heading" role="tab" id="{{ 'heading-' . $counter }}">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{ 'collapse-' . $counter }}" aria-controls="{{ 'collapse-' . $counter }}">
                                        <i class="ion ion-arrow-right-b"></i> {{ $complaintProductReply->created_by->name }}
                                    </a>
                                </h4>
                            </div>
                            <div id="{{ 'collapse-' . $counter }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{ 'heading-' . $counter }}">
                                <div class="panel-body">
                                    {{ $complaintProductReply->reply_content }}
                                </div>
                            </div>
                        </div>
                        @php $counter++; @endphp
                    @endforeach
                </div>
            </div>
        @endisset

        <div class="col-lg-10" id="reply_box" v-if="showReply == true">
            <div class="box box-danger">
                <!-- /.box-header -->
                {{ Form::open(['action' => 'Complaint\ComplaintProductReplyController@store', 'id' => 'form_complaint_product_reply']) }}
                {{ Form::hidden('customerId', $complaintProduct->customer->systemId) }}
                {{ Form::hidden('complaintProductId',$complaintProduct->systemId) }}

                <div class="box-body">
                    <div class="form-group">
                        <span>Reply to : </span> <span v-html="replyTo"></span>
                    </div>
                    <div class="form-group" v-bind:class="{'has-error': errors.has('reply_content')}">
                        <textarea id="reply_content"
                                  name="reply_content"
                                  class="form-control"
                                  placeholder="Reply. . ."
                                  rows="6"
                                  v-validate="'required'">
                        </textarea>
                        <span class="help-block text-red" v-show="errors.has('reply_content')">
                            @{{ errors.first('reply_content') }}
                        </span>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="button" @click="submitReply()" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                    </div>
                    <button type="reset" @click="showReply = false" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                </div>
                <!-- /.box-footer -->

                {{ Form::close() }}
            </div>
            <!-- /. box -->
        </div>
    </div>
    <!-- /.col -->


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
@endsection