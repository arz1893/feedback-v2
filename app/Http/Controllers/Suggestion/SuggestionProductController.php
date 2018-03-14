<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\Http\Requests\Suggestion\SuggestionProductRequest;
use App\Http\Resources\SuggestionProductCollection;
use App\Product;
use App\ProductCategory;
use App\SuggestionProduct;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;
use App\Http\Resources\SuggestionProduct as SuggestionProductResource;

class SuggestionProductController extends Controller
{
    public function index() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $defaultTags = Tag::where('recOwner', Auth::user()->tenantId)->where('defValue', 1)->orderBy('name', 'asc')->pluck('systemId');
        $products = Product::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->paginate(6);
        return view('suggestion.product.suggestion_product_index', compact('products', 'selectTags', 'defaultTags'));
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

    public function store(SuggestionProductRequest $request) {
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
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $request->productId . '/' . $filename,
                'syscreator' => Auth::user()->systemId
            ]);
        } else {
            SuggestionProduct::create([
                'systemId' => $id,
                'customer_suggestion' => $request->customer_suggestion,
                'customerId' => $request->customerId,
                'productId' => $request->productId,
                'productCategoryId' => $request->productCategoryId,
                'tenantId' => $request->tenantId,
                'syscreator' => Auth::user()->systemId
            ]);
        }

        return redirect('suggestion_product_list')->with('status', 'A new suggestion has been added');
    }

    public function getSuggestionProduct(Request $request, $suggestion_product_id) {
        $suggestionProduct = SuggestionProduct::findOrFail($suggestion_product_id);
        return new SuggestionProductResource($suggestionProduct);
    }

    public function getAllSuggestionProduct(Request $request, $tenantId) {
        $suggestionProducts = SuggestionProduct::where('tenantId', $tenantId)->orderBy('created_at', 'desc')->paginate(20);
        return new SuggestionProductCollection($suggestionProducts);
    }

    public function filterByDate(Request $request, $tenantId, $from, $to) {
        if($from == $to) {
            $filteredSuggestionProducts = SuggestionProduct::where('tenantId', $tenantId)->whereDate('created_at', '=', $from)->orderBy('created_at', 'desc')->paginate(20);
            return new SuggestionProductCollection($filteredSuggestionProducts);
        } else if($from > $to) {
            $filteredSuggestionProducts = SuggestionProduct::where('tenantId', $tenantId)->whereBetween('created_at', [$to, $from])->orderBy('created_at', 'desc')->paginate(20);
            return new SuggestionProductCollection($filteredSuggestionProducts);
        } else {
            $filteredSuggestionProducts = SuggestionProduct::where('tenantId', $tenantId)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(20);
            return new SuggestionProductCollection($filteredSuggestionProducts);
        }
    }

    public function filterByCustomer(Request $request, $tenantId, $customerId) {
        if($customerId == -1) {
            $filteredSuggestionProducts = SuggestionProduct::where('tenantId', $tenantId)->where('customerId', null)->paginate(10);
            return new SuggestionProductCollection($filteredSuggestionProducts);
        } else {
            $filteredSuggestionProducts = SuggestionProduct::where('tenantId', $tenantId)->where('customerId', $customerId)->paginate(10);
            return new SuggestionProductCollection($filteredSuggestionProducts);
        }
    }
}
