@extends('home')

@section('content-header')
    <h3> Customer List </h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customer</li>
    </ol>
@endsection

@section('main-content')
    <table class="table table-striped table-bordered" id="table_customer" style="width: 100%;">
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
                    <td>{{ $customer->name }}</td>
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
                        <a role="button" class="btn btn-warning">
                            <i class="fa fa-edit"></i>
                        </a>
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