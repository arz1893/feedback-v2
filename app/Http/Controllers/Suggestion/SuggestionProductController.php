<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\Product;
use App\ProductCategory;
use App\SuggestionProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

class SuggestionProductController extends Controller
{
    public function index() {
        $products = Product::where('tenantId', Auth::user()->tenantId)->paginate(6);
        return view('suggestion.product.suggestion_product_index', compact('products'));
    }

    public function showProduct($id, $currentNodeId) {
        if($currentNodeId == 0) {
            $product = Product::findOrFail($id);
            $productCategories = ProductCategory::where('productId', $product->systemId)->where('parent_id', null)->get();
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
            return view('suggestion.product.suggestion_product_show', compact('product', 'productCategories', 'selectCustomers'));
        } else {
            $product = Product::findOrFail($id);
            $productCategories = ProductCategory::where('parent_id', $currentNodeId)->get();
            $currentParentNode = ProductCategory::findOrFail($currentNodeId);
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
            return view('suggestion.product.suggestion_product_show', compact('product', 'productCategories', 'currentParentNode', 'selectCustomers'));
        }
    }

    public function store(Request $request) {
        $rules = [
            'customer_suggestion' => 'required'
        ];
        $messages = [
            'customer_suggestion.required' => 'please enter customer\'s suggestion'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $file_attachment = $request->file('attachment');
        $id = Uuid::generate(4);

        if(!is_null($file_attachment)) {
            $filename = $id . '-' . $file_attachment->getClientOriginalName();
            if(!file_exists(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $request->productId))) {
                mkdir(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $request->productId), 0777, true);
            }
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $request->productId . '/'), $filename);

            SuggestionProduct::create([
                'systemId' => $id,
                'customer_suggestion' => $request->customer_suggestion,
                'customerId' => $request->customerId,
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $request->tenantId,
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $request->productId . '/' . $filename
            ]);
        } else {
            SuggestionProduct::create([
                'systemId' => $id,
                'customer_suggestion' => $request->customer_suggestion,
                'customerId' => $request->customerId,
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $request->tenantId
            ]);
        }

        return redirect('suggestion_product_list')->with('status', 'A new suggestion has been added');
    }

    public function edit($id) {
        dd($id);
    }
}
