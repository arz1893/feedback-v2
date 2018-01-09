<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\ServiceRequest;
use App\Service;
use App\ServiceCategory;
use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::where('tenantId', Auth::user()->tenantId)->get();
        return view('master_data.service.service_index', compact('services'));
    }

    public function create() {
        return view('master_data.service.service_add');
    }

    public function store(ServiceRequest $request) {
        $image = $request->file('image_cover');

        if($image != null) {
            $id = Uuid::generate(4);
            $tenant = Tenant::findOrFail(Auth::user()->tenantId);
            $filename = $id . '_' . $image->getClientOriginalName();

            Service::create([
                'systemId' => $id,
                'name' => $request->name,
                'description' => $request->description,
                'img' => '/uploaded_images/' . $tenant->email . '/' . $filename,
                'tenantId' => Auth::user()->tenantId
            ]);

            if(!file_exists(public_path('uploaded_images/' . $tenant->email))) {
                mkdir(public_path('uploaded_images/' . $tenant->email), 0777, true);
                $image->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
            } else {
                $image->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
            }

            return redirect('service')->with('status', 'A new service has been added');
        } else {
            Service::create([
                'systemId' => Uuid::generate(4),
                'name' => $request->name,
                'description' => $request->description,
                'tenantId' => Auth::user()->tenantId
            ]);

            return redirect('service')->with('status', 'A new service has been added');
        }
    }

    public function edit(Service $service) {
        return view('master_data.service.service_edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service) {
        $service->update($request->all());
        return redirect('service')->with('status', 'Service has been updated');
    }

    public function show(Service $service) {
        $serviceCategories = ServiceCategory::where('serviceId', $service->systemId)->where('parent_id', null)->get();

        $hasCategory = false;
        if(count($serviceCategories) > 0) {
            $hasCategory = true;
        }

        return view('master_data.service.service_show', compact('service', 'hasCategory'));
    }

    public function changePicture(Request $request, $id) {
        $uploadedImage = $request->file('service_picture');
        $service = Service::findOrFail($id);
        $tenant = Tenant::findOrFail($service->tenantId);
        $filename = $id . '_' . $uploadedImage->getClientOriginalName();

        if(file_exists(public_path($service->img))) {
            unlink(public_path($service->img));
            $uploadedImage->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
            $service->img = '/uploaded_images/' . $tenant->email . '/' . $filename;
            $service->update();
            return redirect()->back()->with('status', 'Product picture has been updated');
        } else {
            $uploadedImage->move(public_path('uploaded_images/' . $tenant->email . '/'), $filename);
            $service->img = '/uploaded_images/' . $tenant->email . '/' . $filename;
            $service->update();
            return redirect()->back()->with('status', 'Product picture has been updated');
        }
    }

    public function deleteService(Request $request) {
        $service = Service::findOrFail($request->service_id);
        if(file_exists(public_path($service->img))) {
            unlink(public_path($service->img));
        }
        $service->delete();
        return redirect('service')->with('status', 'Service has been deleted');
    }
}