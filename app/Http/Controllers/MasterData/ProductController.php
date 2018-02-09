<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Product;
use App\ProductCategory;
use App\Tag;
use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    public function index() {
        $products = Product::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get();
        return view('master_data.product.product_index', compact('products'));
    }

    public function create() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->pluck('name', 'systemId');
        return view('master_data.product.product_add', compact('selectTags'));
    }

    public function store(ProductRequest $request) {
        $tenant = Tenant::findOrFail($request->tenantId);
        $id = Uuid::generate(4);
        $image = $request->file('image_cover');
        if(!is_null($image)) {
            $filename = $id . '_' . $image->getClientOriginalName();

            $product = Product::create([
                'systemId' => $id,
                'name' => $request->name,
                'description' => $request->description,
                'metric' => $request->metric,
                'price' => $request->price,
                'img' => '/uploaded_images/' . $tenant->email . '/' . $filename,
                'tenantId' => $request->tenantId
            ]);

            $product->tags()->sync($request->input('tags'));

            if(!file_exists(public_path('uploaded_images/' . $tenant->email))) {
                mkdir(public_path('uploaded_images/' . $tenant->email), 0777, true);
                $image->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
            } else {
                $image->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
            }
        } else {
            $product = Product::create([
                'systemId' => $id,
                'name' => $request->name,
                'description' => $request->description,
                'metric' => $request->metric,
                'price' => $request->price,
                'tenantId' => $request->tenantId
            ]);

            $product->tags()->sync($request->input('tags'));

        }
        return redirect('product')->with('status', 'Product has been added');
    }

    public function show(Product $product) {
        $productCategories = ProductCategory::where('productId', $product->systemId)->where('parent_id', null)->get();
        $hasCategory = false;
        if(count($productCategories) > 0) {
            $hasCategory = true;
        }
        $productTags = $product->tags;

        return view('master_data.product.product_show', compact('product', 'hasCategory', 'productTags'));
    }

    public function edit(Product $product) {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $selectedTags = $product->tags->pluck('name', 'systemId');
        return view('master_data.product.product_edit', compact('product', 'selectTags', 'selectedTags'));
    }

    public function update(ProductRequest $request, Product $product) {
        $product->update($request->all());
        $product->tags()->sync($request->input('tags'));
        return redirect('product')->with('status', 'Product has been updated');
    }

    public function changePicture(Request $request, $id) {
        $uploadedImage = $request->file('product_picture');
        $product = Product::findOrFail($id);
        $tenant = Tenant::findOrFail($product->tenantId);
        $filename = $id . '_' . $uploadedImage->getClientOriginalName();

        if($product->img != null) {
            if(file_exists(public_path($product->img))) {
                unlink(public_path($product->img));
                $uploadedImage->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
                $product->img = '/uploaded_images/' . $tenant->email . '/' . $filename;
                $product->update();
                return redirect()->back()->with('status', 'Product picture has been updated');
            } else {
                $uploadedImage->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
                $product->img = '/uploaded_images/' . $tenant->email . '/' . $filename;
                $product->update();
                return redirect()->back()->with('status', 'Product picture has been updated');
            }
        } else {
            $uploadedImage->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
            $product->img = '/uploaded_images/' . $tenant->email . '/' . $filename;
            $product->update();
            return redirect()->back()->with('status', 'Product picture has been updated');
        }
    }

    public function deleteProduct(Request $request) {
        $product = Product::findOrFail($request->product_id);
        if(file_exists(public_path($product->img))) {
            unlink(public_path($product->img));
        }
        $product->delete();
        return redirect('product')->with('status', 'Product has been deleted');
    }

    public function getProductList($tenant_id) {
        $products = Product::where('tenantId', $tenant_id)->orderBy('created_at', 'desc')->get();
        return new ProductCollection($products);
    }
}
