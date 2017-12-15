<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use App\Http\Requests\Customer\CustomerRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class CustomerController extends Controller
{
    public function store(CustomerRequest $request) {
        $birthdate = date('Y-m-d', strtotime($request->input('birthdate')));

        Customer::create([
            'systemId' => Uuid::generate(4),
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthdate' => $birthdate,
            'address' => $request->address,
            'nation' => $request->nation,
            'city' => $request->city,
            'memo' => $request->memo,
            'tenantId' => Auth::user()->tenantId
        ]);

        return redirect()->back()->with(['status' => 'Customer has been added']);
    }
}
