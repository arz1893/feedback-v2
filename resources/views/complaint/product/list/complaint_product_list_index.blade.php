@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/product/complaint/vue_complaint_product_list.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 class="text-red" style="margin-top: -0.5%;">Complaint Product List</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Complaint Product List</li>
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

    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div class="container-fluid">
        <form class="form-inline" id="form_search_list">
            <!-- Date range -->
            <div class="form-group">
                <label>From: </label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" id="date_start" name="date_start">
                </div>
                <!-- /.input group -->
            </div>

            <!-- Date range -->
            <div class="form-group">
                <label>To: </label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" id="date_end" name="date_end">
                </div>
                <!-- /.input group -->
            </div>

            <button class="btn btn-default disabled" type="button" id="btnSearchByDate">
                Search <i class="fa fa-search"></i>
            </button>
            <button class="btn btn-warning disabled" type="button" id="btnClearSearch">
                Clear Search <i class="fa fa-close"></i>
            </button>
        </form>
    </div>

    <br>

    <div id="complaint_product_list_index">
        <div v-if="searchStatus.length > 0" class="text-center"><i class="fa fa-spinner fa-spin"></i> @{{ searchStatus }}</div>
        <div v-show="errorMessage !== ''">
            <div class="well text-center">
                @{{ errorMessage }}
            </div>
        </div>
        <div class="table-responsive">
            <table v-show="searchStatus === '' & errorMessage === ''" class="table table-striped table-bordered table-responsive" id="table_complaint_product" style="width: 100%">
                <thead>
                <tr>
                    <th>Created at</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Rating</th>
                    <th>Need Call?</th>
                    <th>Urgent?</th>
                    <th>Answered?</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="complaintProduct in complaintProducts">
                        <td>
                            <a role="button" v-bind:data-complaint_id="complaintProduct.systemId" @click="showComplaintDetail($event)">
                                @{{ complaintProduct.created_at }}
                            </a>
                        </td>
                        <td>
                            <span v-if="complaintProduct.customer !== null">
                                <a role="button" v-bind:data-complaint_id="complaintProduct.systemId" @click="showComplaintDetail($event)">
                                    @{{ complaintProduct.customer.name }}
                                </a>
                            </span>
                            <span v-else>
                                <a role="button" v-bind:data-complaint_id="complaintProduct.systemId" @click="showComplaintDetail($event)">
                                    Anonymous
                                </a>
                            </span>
                        </td>
                        <td>@{{ complaintProduct.product.name }}</td>
                        <td>
                            <span v-if="complaintProduct.customer_rating === 1">
                                <i class="text-center material-icons text-maroon" style="font-size: 2em;">
                                    sentiment_very_dissatisfied
                                </i>
                            </span>
                            <span v-else-if="complaintProduct.customer_rating === 2">
                                <i class="text-center material-icons text-red" style="font-size: 2em;">
                                    sentiment_dissatisfied
                                </i>
                            </span>
                            <span v-else-if="complaintProduct.customer_rating === 3">
                                <i class="text-center material-icons text-yellow" style="font-size: 2em;">
                                    sentiment_neutral
                                </i>
                            </span>
                            <span v-else-if="complaintProduct.customer_rating === 4">
                                <i class="text-center material-icons text-olive" style="font-size: 2em;">
                                    sentiment_satisfied
                                </i>
                            </span>
                            <span v-else-if="complaintProduct.customer_rating === 5">
                                <i class="text-center material-icons text-green" style="font-size: 2em;">
                                    sentiment_very_satisfied
                                </i>
                            </span>
                        </td>
                        <td>
                            <span v-if="complaintProduct.is_need_call === 1">Yes</span>
                            <span v-else>No</span>
                        </td>
                        <td>
                            <span v-if="complaintProduct.is_urgent === 1">Yes</span>
                            <span v-else>No</span>
                        </td>
                        <td>
                            <span v-if="complaintProduct.is_answered === 1">Yes</span>
                            <span v-else>No</span>
                        </td>
                        <td>
                            @if(Auth::user()->user_group->name == 'Administrator' || Auth::user()->user_group->name == 'Management')
                                <a v-bind:href="complaintProduct.edit_url" class="btn btn-warning">
                                    <i class="ion ion-edit"></i>
                                </a>
                                <button class="btn btn-danger" :data-id="complaintProduct.systemId" @click="deleteComplaintProduct($event)">
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
            <ul class="pagination">
                <li v-bind:class="{disabled:paging.prevPage === null}">
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="n in paging.endPage" v-bind:class="{ active:n===paging.currentPage }">
                    <a href="#">@{{ n }}</a>
                </li>
                <li v-bind:class="{disabled:paging.nextPage === null}">
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>

        @include('complaint.product.list.modal_complaint_product_list_show')

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
    </div>
@endsection