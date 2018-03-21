@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/service/vue_service.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_report.index') }}"><i class="fa fa-bar-chart-o"></i> Complaint Report Selection</a></li>
        <li class="active">Complaint Service Report</li>
    </ol>
    <h3 class="text-red">Complaint Service Report</h3>
    <a href="{{ route('complaint_service_report_all_yearly') }}" class="btn btn-success">
        Show all report <i class="ion ion-arrow-graph-up-right"></i>
    </a>
    <div>
        <small class="text-muted">Note *: Please select one of the service to view report</small>
    </div>
@endsection

@section('main-content')
    <div id="service_index">
        {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for..." v-model="searchString">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="filterByName()">
                                    <i class="ion ion-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {{ Form::select('tags[]', $selectTags, $defaultTags, ['id' => 'select_tags', 'class' => 'selectize', 'style' => '', 'multiple' => true]) }}
                        <span class="visible-md visible-sm visible-xs">
                            <span v-if="searchStatus.length > 0"><i class="fa fa-spinner fa-spin"></i> @{{ searchStatus }}</span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 visible-lg">
                    <span v-if="searchStatus.length > 0"><i class="fa fa-spinner fa-spin"></i> @{{ searchStatus }}</span>
                </div>
            </div>
        </div>

        <transition name="fade" mode="out-in">
            <div id="service_panel" class="col-lg-12">
                <div class="row visible-lg visible-md visible-sm">
                    <div v-show="errorMessage !== ''">
                        <div class="well text-center">
                            @{{ errorMessage }}
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4" v-for="service in services">
                        <div class="imagebox">
                            <a href="#!">
                                <img v-show="service.img !== ''" v-bind:src="service.img"  class="category-banner img-responsive">
                                <img v-show="service.img === ''" src="{{ asset('default-images/no-image.jpg') }}"  class="category-banner img-responsive">
                                <span class="imagebox-desc">
                                @{{ service.name }}
                            </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row visible-xs">
                    <div v-show="errorMessage !== ''">
                        <div class="well text-center">
                            @{{ errorMessage }}
                        </div>
                    </div>
                    <div class="list-group">
                        <div v-for="service in services">
                            <a href="#!" class="list-group-item">
                                <img v-bind:src="service.img" style="width: 40px; height: 30px;">
                                @{{ service.name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <div class="col-lg-12">
            <ul class="pager">
                <li v-show="pagination.prev_page_link === null" v-bind:class="{'disabled' : pagination.prev_page_link === null}"><a href="#prev">&larr; Prev</a></li>
                <li v-show="pagination.prev_page_link !== null"><a href="#prev" @click="nextPage(pagination.prev_page_link)">&larr; Prev</a></li>
                <li v-show="pagination.next_page_link === null" v-bind:class="{'disabled' : pagination.next_page_link === null}"><a href="#next">Next &rarr;</a></li>
                <li v-show="pagination.next_page_link !== null"><a href="#next" @click="nextPage(pagination.next_page_link)">Next &rarr;</a></li>
            </ul>
            <div class="text-center">Page @{{ pagination.current_page }} of @{{ pagination.total_page }}</div>
        </div>
    </div>
@endsection