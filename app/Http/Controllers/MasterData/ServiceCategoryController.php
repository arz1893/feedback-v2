<?php

namespace App\Http\Controllers\MasterData;

use App\ServiceCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    public function store(Request $request) {
        $rules = [
            'name' => 'required'
        ];

        $messages = [
            'name.required' => 'please enter category name'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->category_type == 'root') {
            ServiceCategory::create([
                'name' => $request->name,
                'serviceId' => $request->service_id
            ]);
            return redirect()->back()->with('status', 'Category has been added');
        } else if($request->category_type == 'sub') {
            $parent = ServiceCategory::findOrFail($request->parent_id);
            $child = ServiceCategory::create([
                'name' => $request->name
            ]);
            $child->makeChildOf($parent);
            return redirect()->back()->with('status', 'Sub category has been added');
        }

        return redirect()->route('master_service.show', $request->service_id);
    }

    public function getTrees(Request $request) {
        if($request->json()) {
            $serviceCategories = ServiceCategory::where('serviceId', $request->service_id)->get();
            $data = [];
            foreach ($serviceCategories as $serviceCategory) {
                $data[] = [
                    'title' => $serviceCategory->name,
                    'key' => $serviceCategory->id,
                    'folder' => true,
                    'lazy' => true
                ];
            }
            return response()->json($data, 200);
        }
        return redirect()->back();
    }

    public function getChilds(Request $request) {
        if($request->json()) {
            $childs = ServiceCategory::where('parent_id', $request->parent_id)->get();
            $data = [];
            foreach ($childs as $child) {
                $data[] = [
                    'title' => $child->name,
                    'key' => $child->id,
                    'folder' => true,
                    'lazy' => true
                ];
            }
            return response()->json($data, 200);
        }
        return redirect()->back();
    }

    public function getCategory(Request $request) {
        if($request->json()) {
            $category = ServiceCategory::findOrFail($request->node_key);
            return response()->json($category, 200);
        }
        return redirect()->back();
    }

    public function renameServiceCategory(Request $request) {
        $serviceCategory = ServiceCategory::findOrFail($request->node_key);
        $serviceCategory->name = $request->name;
        $serviceCategory->update();
        return redirect()->back()->with('status', 'Category has been updated');
    }

    public function deleteServiceCategory(Request $request) {
        $serviceCategory = ServiceCategory::findOrFail($request->node_key);
        $serviceCategory->delete();
        return redirect()->back()->with('status', 'Category has been deleted');
    }

    public function addParentNode(Request $request) {
        if($request->json()) {
            $parent = ServiceCategory::create([
                'name' => $request->category_name,
                'serviceId' => $request->service_id
            ]);

            return response()->json($parent, 200);
        }
        return redirect()->back();
    }

    public function addChildNode(Request $request) {
        if($request->json()) {
            $parent = ServiceCategory::findOrFail($request->parent_id);
            $child = ServiceCategory::create([
                'name' => $request->name
            ]);
            $child->makeChildOf($parent);
            return response()->json($child, 200);
        }
        return redirect()->back();
    }

    public function renameNode(Request $request) {
        if($request->json()) {
            $node = ServiceCategory::findOrFail($request->node_key);
            $node->name = $request->name;
            $node->update();
            return response()->json();
        }
        return redirect()->back();
    }

    public function deleteNode(Request $request) {
        if($request->json()) {
            $node = ServiceCategory::findOrFail($request->node_id);
            $node->delete();
            return response()->json(['status' => 'success'], 200);
        }
        return redirect()->back();
    }
}
