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
    public function addCustomer(Request $request) {

        $isExist = Customer::where('tenantId', $request->tenantId)->where('phone', $request->customer['phone'])->first();

        if(count($isExist) > 0) {
            return ['error' => 'customer already exist'];
        } else {
            $customer = Customer::create([
                'systemId' => Uuid::generate(4),
                'name' => $request->customer['name'],
                'gender' => $request->customer['gender'],
                'email' => $request->customer['email'],
                'phone' => $request->customer['phone'],
                'birthdate' => date('Y-m-d', strtotime($request->customer['birthdate'])),
                'address' => $request->customer['address'],
                'nation' => $request->customer['nation'],
                'city' => $request->customer['city'],
                'memo' => $request->customer['memo'],
                'tenantId' => $request->tenantId
            ]);

            return response()->json(['systemId' => utf8_encode($customer->systemId), 'name' => utf8_encode($customer->name), 'phone' => utf8_encode($customer->phone)], 200);
        }
    }
}
