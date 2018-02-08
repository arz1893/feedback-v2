<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintProduct;
use App\Customer;
use App\Http\Requests\Complaint\ComplaintProductRequest;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

class ComplaintProductController extends Controller
{
    public function index() {
        $products = Product::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->paginate(6);
        return view('complaint.product.complaint_product_index', compact('products'));
    }

    public function showProduct($id, $currentNodeId) {
        if($currentNodeId == 0) {
            $product = Product::findOrFail($id);
            $productCategories = ProductCategory::where('productId', $product->systemId)->where('parent_id', null)->get();
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
            return view('complaint.product.complaint_product_show', compact('product', 'productCategories', 'selectCustomers'));
        } else {
            $product = Product::findOrFail($id);
            $productCategories = ProductCategory::where('parent_id', $currentNodeId)->get();
            $currentParentNode = ProductCategory::findOrFail($currentNodeId);
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
            return view('complaint.product.complaint_product_show', compact('product', 'productCategories', 'currentParentNode', 'selectCustomers'));
        }
    }

    public function store(ComplaintProductRequest $request) {
        $file_attachment = $request->file('attachment');

        $id = Uuid::generate(4);
        if(!is_null($file_attachment)) {
            $filename = $id . '-' . $file_attachment->getClientOriginalName();
            if(!file_exists(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_product/' . $request->productId))) {
                mkdir(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_product/' . $request->productId), 0777, true);
            }
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_product/' . $request->productId . '/'), $filename);
            ComplaintProduct::create([
                'systemId' => $id,
                'customer_complaint' => $request->customer_complaint,
                'customer_rating' => $request->customer_rating,
                'is_need_call' => $request->is_need_call,
                'is_urgent' => $request->is_urgent,
                'customerId' => $request->customerId,
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $request->tenantId,
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/complaint_product/' . $request->productId . '/' . $filename,
                'syscreator' => Auth::user()->systemId
            ]);
        } else {
            ComplaintProduct::create([
                'systemId' => $id,
                'customer_complaint' => $request->customer_complaint,
                'customer_rating' => $request->customer_rating,
                'is_need_call' => $request->is_need_call,
                'is_urgent' => $request->is_urgent,
                'customerId' => $request->customerId,
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $request->tenantId,
                'syscreator' => Auth::user()->systemId
            ]);
        }
        return redirect()->back()->with('status', 'New complaint has been added, please check your complaint product list');
    }
}
