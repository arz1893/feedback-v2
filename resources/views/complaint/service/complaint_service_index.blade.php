@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_service.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/complaint') }}"><i class="ion ion-settings"></i> Complaint selection</a></li>
        <li class="active">Complaint Service</li>
    </ol>
    <span class="text-danger" style="font-size: 2em; position: relative; top: 5px;">Complaint</span>
    <a href="{{ route('complaint_product.index') }}" class="btn btn-sm btn-link">Product</a>
    <a href="{{ route('complaint_service.index') }}" class="btn btn-sm btn-flat bg-aqua">Service</a>
@endsection

@section('main-content')
    <div id="complaint_service_index">
        {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for..." v-model="searchString">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                    <i class="ion ion-search"></i>
                                </button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="input-group">
                            {{ Form::select('tags[]', $selectTags, null, ['class' => 'select2-tag', 'multiple' => true,'style' => 'width: 100%;']) }}
                        </div><!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>

        <div id="service_panel" class="col-lg-12">
            @if(count($services) == 0)
                <div class="well">
                    <h4 class="text-center">Sorry you don't have any service yet</h4>
                </div>
            @endif
            <div class="row visible-lg visible-md visible-sm">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4" v-for="service in filteredServices">
                    <div class="imagebox">
                        <a v-bind:href="service.show_url">
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
                <div class="list-group">
                    <div v-for="service in filteredServices">
                        <a v-bind:href="service.show_url" class="list-group-item">
                            <img v-bind:src="service.img" style="width: 40px; height: 30px;">
                            @{{ service.name }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="text-center">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection