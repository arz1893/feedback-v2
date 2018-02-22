<div id="modal_suggestion_service_show" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-orange">Suggestion Detail</h4>
                <div>
                    <span class="text-muted">Posted By:</span>
                    <span class="text-blue"> @{{ suggestionService.created_by }} </span>
                </div>
            </div>
            <div class="modal-body">
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" v-if="suggestionService.service.img !== ''" v-bind:src="suggestionService.service.img" width="125px">
                            <img class="media-object" v-else src="{{ asset('default-images/no-image.jpg') }}" width="125px">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading text-orange">
                            @{{ suggestionService.service.name }} (@{{ suggestionService.serviceCategory.name }}) <br>
                            <span class="mailbox-read-time">@{{ suggestionService.created_at }}</span>
                        </h4>
                        <div>Suggestion from:
                            <span id="reply_to" class="text-info">
                                <span v-if="suggestionService.customer !== null">@{{ suggestionService.customer.name }}</span>
                                <span v-else> Anonymous </span>
                            </span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <dl>
                            <dt class="text-muted">Suggestion:</dt>
                            <dd>@{{ suggestionService.customer_suggestion }}</dd>
                        </dl>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div v-show="suggestionService.attachment != null">
                            <dl>
                                <dt class="text-muted">Attachment :</dt>
                                <dd>
                                    <ul class="mailbox-attachments clearfix">
                                        <li style="width: 155px;">
                                            <a>
                                        <span class="mailbox-attachment-icon has-img">
                                            <img v-bind:src="suggestionService.attachment" alt="Attachment">
                                        </span>
                                            </a>
                                            <div class="mailbox-attachment-info">
                                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> attachment</a>
                                                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->