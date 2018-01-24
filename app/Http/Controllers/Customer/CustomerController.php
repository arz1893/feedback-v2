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
    public function store(Request $request) {
//        dd($request->all());

        $birthdate = date('Y-m-d', strtotime($request->birthdate));

        $customer = Customer::create([
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

        return response()->json(['systemId' => utf8_encode($customer->systemId), 'name' => utf8_encode($customer->name), 'phone' => utf8_encode($customer->phone)], 200);
//
//        return redirect()->back()->with(['status' => 'Customer has been added']);
    }
}
