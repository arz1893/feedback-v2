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
        <form class="form-inline">
            <!-- Date range -->
            <div class="form-group">
                <label>From: </label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" id="date_start">
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
                    <input type="text" class="form-control pull-right datepicker" id="date_end">
                </div>
                <!-- /.input group -->
            </div>

            <button class="btn btn-default" type="button" id="btnSearchByDate" onclick="searchByDate(this)">
                Search <i class="fa fa-search"></i>
            </button>
            <button class="btn btn-warning disabled" type="button" id="btnClearSearch">
                Clear Search <i class="fa fa-close"></i>
            </button>
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
                        Are you sure want to delete this complaint ?
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