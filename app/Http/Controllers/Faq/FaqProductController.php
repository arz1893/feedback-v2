<?php

namespace App\Http\Controllers\Faq;

use App\FaqProduct;
use App\Http\Requests\Faq\FaqProductRequest;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

class FaqProductController extends Controller
{
    public function index() {
        $products = Product::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->paginate(6);
        return view('faq.product.faq_product_index', compact('products'));
    }

    public function show($id) {
        $product = Product::findOrFail($id);
        $faqProducts = FaqProduct::where('productId', $product->systemId)->orderBy('created_at', 'asc')->get();
        return view('faq.product.faq_product_show', compact('product', 'faqProducts'));
    }

    public function store(FaqProductRequest $request) {
        FaqProduct::create([
            'systemId' => Uuid::generate(4),
            'question' => $request->question,
            'answer' => $request->answer,
            'productId' => $request->productId
        ]);
        return redirect()->back()->with('status', 'A new FAQ has been updated');
    }

    public function edit(FaqProduct $faqProduct) {
        return view('faq.product.faq_product_edit', compact('faqProduct'));
    }

    public function update(FaqProductRequest $request, FaqProduct $faqProduct) {
        $faqProduct->update($request->all());
        return redirect()->route('faq_product.show', $faqProduct->productId)->with('status', 'FAQ has been updated');
    }

    public function deleteFaqProduct(Request $request) {
        $faqProduct = FaqProduct::findOrFail($request->faq_product_id);
        $product_id = $faqProduct->productId;
        $faqProduct->delete();
        return redirect()->route('faq_product.show', $product_id)->with('status', 'FAQ has been deleted');
    }
}
