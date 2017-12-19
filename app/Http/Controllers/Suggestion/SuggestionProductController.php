<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->pluck('name', 'systemId');
            return view('suggestion.product.suggestion_product_show', compact('product', 'productCategories', 'selectCustomers'));
        } else {
            $product = Product::findOrFail($id);
            $productCategories = ProductCategory::where('parent_id', $currentNodeId)->get();
            $currentParentNode = ProductCategory::findOrFail($currentNodeId);
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->pluck('name', 'systemId');
            return view('suggestion.product.suggestion_product_show', compact('product', 'productCategories', 'currentParentNode', 'selectCustomers'));
        }
    }

    public function store(Request $request) {
        dd($request->all());
    }
}
