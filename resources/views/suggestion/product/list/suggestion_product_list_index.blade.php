@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/product/suggestion/vue_suggestion_product.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 class="text-orange" style="margin-top: -0.5%;">Suggestion Product List</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Suggestion Product List</li>
    </ol>
    <button class="btn btn-success" style="margin-top: 1%;" id="btnClearSearch" onclick="clearSearch()">
        Refresh List <i class="fa fa-refresh"></i>
    </button>
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

    <div class="row visible-lg visible-md visible-xs">

        <div class="col-lg-8">
            <form class="form-inline pull-left" id="form_search_list">
                <!-- Date range -->
                <div class="form-group">
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

        <div class="col-lg-4">
            <form class="form-inline visible-lg">
                <div class="row">
                    <div class="input-group col-lg-12">
                        {{--<select name="customer_name" id="customer_name" class="select2-customer" style="width: 100%">--}}
                        {{--<option></option>--}}
                        {{--<option value="-1">Anonymous</option>--}}
                        {{--@foreach($selectCustomers as $selectCustomer)--}}
                        {{--<option value="{{ $selectCustomer->systemId }}">{{ $selectCustomer->name }} - {{ $selectCustomer->phone }}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{ Form::select('product_name', $selectProducts, null, ['style' => 'width: 100%', 'class' => 'select2-product', 'id' => 'product_name', 'placeholder' => 'Choose Product...']) }}
                        <span class="input-group-btn">
                            <button class="btn btn-default disabled" id="btnSearchProduct" type="button" data-toggle="tooltip" data-placement="bottom" title="Search by product">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>


    </div>

    <div class="container-fluid visible-sm">
        <form id="form_search_list">
            <!-- Date range -->
            <div class="form-group col-sm-6">
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
            <div class="form-group col-sm-6">
                <label>To: </label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" id="date_end" name="date_end">
                </div>
                <!-- /.input group -->
            </div> <br> <br>

            <div class="form-group col-sm-12">
                <button class="btn btn-default disabled" type="button" id="btnSearchByDate">
                    Search <i class="fa fa-search"></i>
                </button>
                <button class="btn btn-warning disabled" type="button" id="btnClearSearch">
                    Clear Search <i class="fa fa-close"></i>
                </button>
            </div>
        </form>
    </div>

    <br>

    <div id="suggestion_product_list_container">
        <div v-if="searchStatus.length > 0" class="text-center"><i class="fa fa-spinner fa-spin"></i> @{{ searchStatus }}</div>
        <div v-show="errorMessage !== ''">
            <div class="well text-center">
                @{{ errorMessage }}
            </div>
        </div>
        <table v-show="searchStatus === '' & errorMessage === ''" class="table table-striped table-bordered table-responsive" id="table_suggestion_product" style="width: 100%">
            <thead>
            <tr>
                <th>Created At</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="suggestionProduct in suggestionProducts">
                    <td>
                        <a role="button" v-bind:data-suggestion_product_id="suggestionProduct.systemId" @click="showSuggestionDetail($event)">@{{ suggestionProduct.created_at }}</a>
                    </td>
                    <td>
                        <span v-if="suggestionProduct.customer !== null">
                            <a role="button" v-bind:data-suggestion_product_id="suggestionProduct.systemId" @click="showSuggestionDetail($event)">@{{ suggestionProduct.customer.name }}</a>
                        </span>
                        <span v-else>
                            <a role="button" v-bind:data-suggestion_product_id="suggestionProduct.systemId" @click="showSuggestionDetail($event)">Anonymous</a>
                        </span>
                    </td>
                    <td>
                        @{{ suggestionProduct.product.name }}
                    </td>
                    <td>
                        @if(Auth::user()->user_group->name == 'Administrator' || Auth::user()->user_group->name == 'Management')
                            <a v-bind:href="suggestionProduct.edit_url" class="btn btn-warning">
                                <i class="ion ion-edit"></i>
                            </a>
                            <button class="btn btn-danger" :data-id="suggestionProduct.systemId" @click="deleteSuggestionProduct($event)">
                                <i class="ion ion-ios-trash"></i>
                            </button>
                        @else
                            <span class="text-red">Not Authorized</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

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

        @include('suggestion.product.list.modal_suggestion_product_show')

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
                        Are you sure want to delete this suggestion ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Remove Suggestion</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection