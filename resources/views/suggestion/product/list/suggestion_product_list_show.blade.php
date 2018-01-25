@extends('home')

@section('content-header')
    <h3 class="text-orange">Suggestion Detail</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>
            <a href="{{ route('suggestion_product_list.index') }}">
                <i class="fa fa-list"></i> Suggestion Product List
            </a>
        </li>
        <li class="active">Show Detail</li>
    </ol>
@endsection

@section('main-content')
    <div class="col-md-9">
        <div class="box box-warning">
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-read-info">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="{{ asset($suggestionProduct->product->img) }}" width="125px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading text-orange">
                                {{ $suggestionProduct->product->name }} ( {{ $suggestionProduct->product_category->name }} )
                                <span class="mailbox-read-time pull-right">{{ $suggestionProduct->created_at->format('d F Y, H:iA') }}</span>
                            </h4>
                        </div>
                    </div>
                    <h5>From:
                        <span id="reply_to" class="text-info">
                            @if($suggestionProduct->customerId != null)
                                {{ $suggestionProduct->customer->name }} \ <i class="ion ion-android-call"></i> {{ $suggestionProduct->customer->phone }}
                            @endif
                        </span>
                    </h5>
                </div>
                <!-- /.mailbox-read-info -->

                <div class="mailbox-read-message">
                    <p>{{ $suggestionProduct->customer_suggestion }}</p>
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                @if($suggestionProduct->attachment != null)
                    <span class="text-muted">Attachment:</span>
                    <ul class="mailbox-attachments clearfix">
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="{{ asset($suggestionProduct->attachment) }}" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i>Attachment</a>
                                <span class="mailbox-attachment-size">
                          1.9 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
                <button type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
                <button type="button" class="btn btn-warning"><i class="ion ion-edit"></i> Edit</button>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
@endsection