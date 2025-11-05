<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/** Admin Service Controller — تحكم الخدمات (مشرف) */
class ServiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Service::class, 'service');
    }

    public function index(): View
    {
        $services = Service::with('category')->latest('id')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.services.create', compact('categories'));
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        Service::create($request->validated());
        return redirect()->route('admin.services.index')->with('success', __('messages.created'));
    }

    public function edit(Service $service): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($request->validated());
        return redirect()->route('admin.services.index')->with('success', __('messages.updated'));
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', __('messages.deleted'));
    }
}
