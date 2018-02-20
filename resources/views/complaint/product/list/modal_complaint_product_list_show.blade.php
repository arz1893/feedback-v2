<div id="modal_complaint_product_show" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-danger">Complaint Detail</h4>
                <div>
                    <span class="text-muted">Posted By:</span>
                    <span class="text-blue"> @{{ complaintProduct.created_by }} </span>
                </div>
            </div>
            <div class="modal-body">
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" v-bind:src="complaintProduct.product.img" width="125px">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading text-danger">
                            <span>@{{ complaintProduct.product.name }}</span> <span>( @{{ complaintProduct.productCategory.name }} )</span>
                            <span class="mailbox-read-time pull-right visible-lg visible-md">@{{ complaintProduct.created_at }}</span>
                            <span class="mailbox-read-time visible-sm visible-xs">@{{ complaintProduct.created_at }}</span>
                        </h5>
                        <div>
                            <span class="text-muted">From:</span>
                            <span id="reply_to" class="text-info">
                                <span v-if="complaintProduct.customer !== null">
                                    @{{ complaintProduct.customer.name }}
                                </span>
                                <span v-else>
                                    Anonymous
                                </span>
                            </span>
                        </div>
                        <div style="margin-top: -2%;">
                            <span class="text-muted">Satisfaction :</span>
                            <span v-if="complaintProduct.customer_rating == 1">
                                <button class="btn btn-link">
                                    <i class="material-icons text-maroon" style="font-size: 2em;">
                                        sentiment_very_dissatisfied
                                    </i>
                                </button>
                            </span>
                            <span v-else-if="complaintProduct.customer_rating == 2">
                                <button class="btn btn-link">
                                    <i class="material-icons text-red" style="font-size: 2em;">
                                        sentiment_dissatisfied
                                    </i>
                                </button>
                            </span>
                            <span v-else-if="complaintProduct.customer_rating == 3">
                                <button class="btn btn-link">
                                    <i class="smiley_rating material-icons text-yellow" style="font-size: 2em;">
                                        sentiment_neutral
                                    </i>
                                </button>
                            </span>
                            <span v-else-if="complaintProduct.customer_rating == 4">
                                <button class="btn btn-link">
                                    <i class="smiley_rating material-icons text-olive" style="font-size: 2em;">
                                        sentiment_satisfied
                                    </i>
                                </button>
                            </span>
                            <span v-else-if="complaintProduct.customer_rating == 5">
                                <button class="btn btn-link">
                                    <i class="smiley_rating material-icons text-green" style="font-size: 2em;">
                                        sentiment_very_satisfied
                                    </i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <span class="text-muted">Complaint : </span> <br>
                        <p align="justify">
                            @{{ complaintProduct.customer_complaint }}
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div v-show="complaintProduct.attachment != null">
                            <span class="text-muted">Attachment :</span>
                            <ul class="mailbox-attachments clearfix">
                                <li style="width: 155px;">
                                    <a>
                                <span class="mailbox-attachment-icon has-img">
                                    <img v-bind:src="complaintProduct.attachment" alt="Attachment">
                                </span>
                                    </a>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> attachment</a>
                                        <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" style="margin-top: 1%;">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button class="btn btn-primary"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#collapseReply"
                                    aria-expanded="false"
                                    aria-controls="collapseReply">
                                <i class="ion ion-chatbubble-working"></i> Reply
                            </button>
                        </div>

                        <div class="form-group">
                            <div class="collapse" id="collapseReply">
                                {{ Form::open(['action' => 'Complaint\ComplaintProductReplyController@store', 'id' => 'form_complaint_product_reply']) }}
                                <input type="hidden" name="complaintProductId" v-bind:value="complaintProduct.systemId">
                                <input type="hidden" name="customerId" v-bind:value="complaintProduct.customer.systemId">
                                <div class="" v-bind:class="{'has-error': errors.has('reply_content')}">
                                <textarea id="reply_content"
                                          name="reply_content"
                                          class="form-control"
                                          placeholder="Content. . ."
                                          rows="4"
                                          v-validate="'required'">
                                </textarea>
                                    <span class="help-block text-red pull-left" v-show="errors.has('reply_content')">
                                    @{{ errors.first('reply_content') }}
                                </span>
                                    <button @click="submitReply($event)" type="button" class="btn btn-success pull-right" style="margin-top: 2%;">
                                        Submit <i class="ion ion-android-send"></i>
                                    </button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>

                <h5>
                    <a role="button"
                       data-toggle="collapse"
                       href="#collapseAllReplies"
                       aria-expanded="false"
                       aria-controls="collapseAllReplies" @click="showComplaintReplies($event)">
                        <i class="ion ion-chatboxes"></i> View All Replies
                    </a>
                </h5>
                <div class="collapse" id="collapseAllReplies">
                    <div class="well">
                        <span v-if="complaintProduct.complaintReplies == null">
                            This complaint doesn't have any replies yet
                        </span>
                        <div v-else class="panel panel-danger" v-for="complaintReply in complaintReplies">
                            <div class="panel-heading">
                                <strong>
                                    @{{ complaintProductReply.created_by.name }} (@{{ complaintProductReply.created_by.role }})
                                </strong>
                            </div>
                            <div class="panel-body">
                                <p>@{{ complaintProductReply.reply_content }}</p>
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
                    </div>
                </div>
            </div>
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
            {{--</div>--}}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->