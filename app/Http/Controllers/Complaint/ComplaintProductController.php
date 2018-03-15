<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintProduct;
use App\Customer;
use App\Http\Requests\Complaint\ComplaintProductRequest;
use App\Http\Resources\ComplaintProductCollection;
use App\Product;
use App\ProductCategory;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;
use App\Http\Resources\ComplaintProduct as ComplaintProductResource;

class ComplaintProductController extends Controller
{
    public function index() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $defaultTags = Tag::where('recOwner', Auth::user()->tenantId)->where('defValue', 1)->orderBy('name', 'asc')->pluck('systemId');
        $products = Product::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->paginate(6);
        return view('complaint.product.complaint_product_index', compact('products', 'selectTags', 'defaultTags'));
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

    public function getComplaintProduct(Request $request, $complaintId) {
        $complaintProduct = ComplaintProduct::findOrFail($complaintId);
        return new ComplaintProductResource($complaintProduct);
    }

    public function getAllComplaintProduct(Request $request, $tenantId) {
        $complaintProducts = ComplaintProduct::where('tenantId', $tenantId)->orderBy('created_at', 'desc')->paginate(10);
        return new ComplaintProductCollection($complaintProducts);
    }

    public function filterByDate(Request $request, $tenantId, $from, $to) {
        $from = date('Y-m-d', strtotime($from));
        $to = date('Y-m-d', strtotime($to));

        if($from == $to) {
            $filteredComplaintProducts = ComplaintProduct::where('tenantId', $tenantId)->whereDate('created_at', '=', $from)->orderBy('created_at', 'desc')->paginate(10);
            return new ComplaintProductCollection($filteredComplaintProducts);
        } else if($from > $to) {
            $filteredComplaintProducts = ComplaintProduct::where('tenantId', $tenantId)->whereBetween('created_at', [$to, $from])->orderBy('created_at', 'desc')->paginate(10);
            return new ComplaintProductCollection($filteredComplaintProducts);
        } else {
            $filteredComplaintProducts = ComplaintProduct::where('tenantId', $tenantId)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(10);
            return new ComplaintProductCollection($filteredComplaintProducts);
        }
    }

    public function filterByProduct(Request $request, $tenantId, $productId) {
        $filteredComplaintProducts = ComplaintProduct::where('tenantId', $tenantId)->where('productId', $productId)->orderBy('created_at', 'desc')->paginate(10);
        return new ComplaintProductCollection($filteredComplaintProducts);
    }

//    public function filterByCustomer(Request $request, $tenantId, $customerId) {
//        if($customerId == -1) {
//            $filteredComplaintProducts = ComplaintProduct::where('tenantId', $tenantId)->where('customerId', null)->paginate(10);
//            return new ComplaintProductCollection($filteredComplaintProducts);
//        } else {
//            $filteredComplaintProducts = ComplaintProduct::where('tenantId', $tenantId)->where('customerId', $customerId)->paginate(10);
//            return new ComplaintProductCollection($filteredComplaintProducts);
//        }
//    }
}
