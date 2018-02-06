<!-- Small boxes (Stat box) -->
<div class="row">

    <a href="{{ url('/faq') }}">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion ion-clipboard"></i></span>

                <div class="info-box-content">
                    {{--<span class="info-box-text">FAQ</span>--}}
                    <span class="info-box-number">FAQ</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                    Frequently asked question
                  </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>

    <a href="{{ url('/complaint') }}">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="ion ion-settings"></i></span>

                <div class="info-box-content">
                    {{--<span class="info-box-text">FAQ</span>--}}
                    <span class="info-box-number">Complaints</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                    Product complaints
                  </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>

    <a href="{{ url('/suggestion') }}">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="ion ion-ribbon-a"></i></span>

                <div class="info-box-content">
                    {{--<span class="info-box-text">FAQ</span>--}}
                    <span class="info-box-number">Suggestions</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                    Product suggestions
                  </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>

    <a href="{{ route('question.index') }}">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion ion-help-circled"></i></span>

                <div class="info-box-content">
                    {{--<span class="info-box-text">FAQ</span>--}}
                    <span class="info-box-number">Questions</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                    customer's question
                  </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>


</div>
<!-- /.row -->

{{--<div class="row">--}}
    {{--<section class="content-header">--}}
        {{--<div class="page-header">--}}
            {{--<h2>List</h2>--}}
        {{--</div>--}}
    {{--</section>--}}

    {{--<div class="content">--}}
        {{--<div class="row">--}}
            {{--<div class="col-lg-3 col-sm-6 col-md-4">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="{{ asset('default-images/complaint-image.jpg') }}" style="height: 175px;">--}}
                    {{--<div class="caption">--}}
                        {{--<h4>List of complaints</h4>--}}
                        {{--<small>Choose which list you want to see</small>--}}
                        {{--<p>--}}
                            {{--<a href="{{ route('complaint_product_list.index') }}" class="btn btn-flat bg-red" role="button">Product</a>--}}
                            {{--<a href="{{ route('complaint_service_list.index') }}" class="btn btn-flat bg-red" role="button">Service</a>--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-lg-3 col-sm-6 col-md-4">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="{{ asset('default-images/suggestion-image.png') }}" style="height: 175px;">--}}
                    {{--<div class="caption">--}}
                        {{--<h4>List of suggestions</h4>--}}
                        {{--<small>Choose which list you want to see</small>--}}
                        {{--<p>--}}
                            {{--<a href="{{ route('suggestion_product_list.index') }}" class="btn btn-flat bg-orange" role="button">Product</a>--}}
                            {{--<a href="{{ route('suggestion_service_list.index') }}" class="btn btn-flat bg-orange" role="button">Service</a>--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-lg-3 col-sm-6 col-md-4">--}}
                {{--<div class="thumbnail">--}}
                    {{--<img src="{{ asset('default-images/questions-image.jpg') }}" style="height: 175px;">--}}
                    {{--<div class="caption">--}}
                        {{--<h4>List of questions</h4>--}}
                        {{--<small>Click here to see all questions</small>--}}
                        {{--<p>--}}
                            {{--<a href="{{ route('question_list.index') }}" class="btn btn-flat bg-green" role="button">Show Questions</a>--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

<div class="row">
    <section class="content-header">
        <div class="page-header">
            <h2>Master Data <small>All of main data source</small></h2>
        </div>
    </section>
    <div class="content">
        <div class="row">

            <a href="{{ route('product.index') }}">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box bg-gray-light">
                        <span class="info-box-icon bg-blue"><i class="ion ion-filing"></i></span>

                        <div class="info-box-content">
                            <b>Products</b> <br>
                            @if($totalProduct == 0)
                                <span class="info-box-text">You don't have any products registered yet</span>
                            @else
                                <span class="info-box-text">{{ 'You have :' . $totalProduct . ' product' }}</span>
                            @endif
                            <span class="info-box-number"></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </a>

            <a href="{{ route('service.index') }}">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box bg-gray-light">
                        <span class="info-box-icon bg-orange"><i class="ion ion-bowtie"></i></span>

                        <div class="info-box-content">
                            <b>Services</b> <br>
                            @if($totalService == 0)
                                <span class="info-box-text">You don't have any services registered yet</span>
                            @else
                                <span class="info-box-text">{{ 'You have :' . $totalService . ' service' }}</span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </a>

            <a href="{{ route('tag.index') }}">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box bg-gray-light">
                        <span class="info-box-icon bg-teal"><i class="ion ion-pricetag"></i></span>

                        <div class="info-box-content">
                            <b>Tags</b> <br>
                            @if($totalTag == 0)
                                <span class="info-box-text">You don't have any tag registered yet</span>
                            @else
                                <span class="info-box-text">{{ 'You have :' . $totalTag . ' tag' }}</span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </a>

        </div>
    </div>
</div>