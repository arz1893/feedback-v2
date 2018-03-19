@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3> Customer List </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customer</li>
    </ol>
@endsection

@section('main-content')
    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div class="alert alert-success" role="alert" id="alert_customer_success" style="display: none;">
        <strong>Success!</strong> Customer has been updated
    </div>

    <table class="table table-striped table-hover table-bordered" id="table_customer" style="width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>
                        <a role="button" data-toggle="modal" data-target="#modal_edit_customer" data-id="{{ $customer->systemId }}" onclick="showCustomer(this)">
                            {{ $customer->name }}
                        </a>
                    </td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        @if($customer->email !== null)
                            {{ $customer->email }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($customer->gender == 1)
                            Male
                        @else
                            Female
                        @endif
                    </td>
                    <td>
                        @if($customer->address !== null)
                            {{ $customer->address }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
                @php $counter++; @endphp
            @endforeach
        </tbody>
    </table>

    @include('customer.modal_edit_customer')
@endsection