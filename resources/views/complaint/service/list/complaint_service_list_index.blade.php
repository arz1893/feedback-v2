@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/service/complaint/vue_complaint_service_list.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/moment/moment.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 class="text-red" style="margin-top: -0.5%;">Complaint Service List</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Complaint Service List</li>
    </ol>
    <button class="btn btn-success" style="margin-top: 1%;" id="btnClearSearch" onclick="clearSearch()">
        Refresh List <i class="fa fa-refresh"></i>
    </button>
@endsection

@section('main-content')

    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 col-md-4 col-sm-5">
            <form class="form-inline pull-left" id="form_search_list">
                <!-- Date range -->
                <div class="form-group">
                    <label for="date_start">From :</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right datepicker" id="date_start" name="date_start" value="{{ date('d-M-Y') }}">
                    </div>
                    <!-- /.input group -->
                </div>

                <!-- Date range -->
                <div class="form-group">
                    <label for="date_end">To :</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right datepicker" id="date_end" name="date_end" value="{{ date('d-M-Y') }}">
                    </div>
                    <!-- /.input group -->
                </div>

                <button class="btn btn-default" type="button" id="btnSearchByDate" data-toggle="tooltip" data-placement="bottom" title="Search by date" onclick="searchByDate()">
                    Search <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-6 pull-right">
            <form class="form-inline">
                <div class="row">
                    <div class="input-group col-lg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{ Form::select('service_name', $selectServices, null, ['style' => 'width: 100%', 'class' => 'select2-service', 'id' => 'service_name', 'placeholder' => 'Choose Service...']) }}
                        <span class="input-group-btn">
                            <button class="btn btn-default disabled" id="btnSearchService" type="button" data-toggle="tooltip" data-placement="bottom" title="Search by service">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br>

    <div id="complaint_service_list_index">
        <div v-if="searchStatus.length > 0" class="text-center"><i class="fa fa-spinner fa-spin"></i> @{{ searchStatus }}</div>
        <div v-show="errorMessage !== ''">
            <div class="well text-center">
                @{{ errorMessage }}
            </div>
        </div>

        <div class="table-responsive">
            <table v-show="searchStatus === '' & errorMessage === ''" class="table table-striped table-bordered" id="table_complaint_service" style="width: 100%">
                <thead>
                <tr>
                    <th>Created At</th>
                    <th>Customer Name</th>
                    <th>Service Name</th>
                    <th>Rating</th>
                    <th>Need Call ?</th>
                    <th>Is Urgent ?</th>
                    <th>Is Answered ?</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="complaintService in complaintServices">
                    <td>
                        <a role="button" v-bind:data-complaint_id="complaintService.systemId" @click="showComplaintDetail($event)">
                            @{{ complaintService.created_at }}
                        </a>
                    </td>
                    <td>
                        <a role="button" v-bind:data-complaint_id="complaintService.systemId" @click="showComplaintDetail($event)">
                            <span v-if="complaintService.customer !== null"> @{{ complaintService.customer.name }} </span>
                            <span v-else>Anonymous</span>
                        </a>
                    </td>
                    <td>
                        @{{ complaintService.service.name }}
                    </td>
                    <td>
                        <span v-if="complaintService.customer_rating === 1">
                            <i class="text-center material-icons text-maroon" style="font-size: 2em;">
                                sentiment_very_dissatisfied
                            </i>
                        </span>
                        <span v-else-if="complaintService.customer_rating === 2">
                            <i class="text-center material-icons text-red" style="font-size: 2em;">
                                sentiment_dissatisfied
                            </i>
                        </span>
                        <span v-else-if="complaintService.customer_rating === 3">
                            <i class="text-center material-icons text-yellow" style="font-size: 2em;">
                                sentiment_neutral
                            </i>
                        </span>
                        <span v-else-if="complaintService.customer_rating === 4">
                            <i class="text-center material-icons text-olive" style="font-size: 2em;">
                                sentiment_satisfied
                            </i>
                        </span>
                        <span v-else-if="complaintService.customer_rating === 5">
                            <i class="text-center material-icons text-green" style="font-size: 2em;">
                                sentiment_very_satisfied
                            </i>
                        </span>
                    </td>
                    <td>
                        <span v-if="complaintService.is_need_call === 1">Yes</span>
                        <span v-else>No</span>
                    </td>
                    <td>
                        <span v-if="complaintService.is_urgent === 1">Yes</span>
                        <span v-else>No</span>
                    </td>
                    <td>
                        <span v-if="complaintService.is_answered === 1">Yes</span>
                        <span v-else>No</span>
                    </td>
                    <td>
                        @if(Auth::user()->user_group->name == 'Administrator' || Auth::user()->user_group->name == 'Management')
                            <a v-bind:href="complaintService.edit_url" class="btn btn-warning">
                                <i class="ion ion-edit"></i>
                            </a>
                            <button class="btn btn-danger" :data-id="complaintService.systemId" @click="deleteComplaintService($event)">
                                <i class="ion ion-ios-trash"></i>
                            </button>
                        @else
                            <span class="text-red">Not Authorized</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <ul v-show="paging.currentPage !== ''" class="pagination">
                <li v-bind:class="{disabled:paging.prevPage === null}">
                    <a v-if="paging.prevPage !== null" role="button" @click="changePage(paging.prevPage)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    <a v-else role="button" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="n in paging.endPage" v-bind:class="{ active:n===paging.currentPage }">
                    <a v-if="n !== paging.currentPage" role="button" @click="changePage(paging.path + '?page=' + n)">@{{ n }}</a>
                    <a v-else role="button">@{{ n }}</a>
                </li>
                <li v-bind:class="{disabled:paging.nextPage === null}">
                    <a v-if="paging.nextPage !== null" @click="changePage(paging.nextPage)" role="button" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    <a v-else role="button">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>

        @include('complaint.service.list.modal_complaint_service_list_show')

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