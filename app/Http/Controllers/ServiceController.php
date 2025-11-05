<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Public Services Controller — عرض الخدمات */
class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q');
        $categorySlug = $request->string('category');
        $active = $request->has('active') ? (bool)$request->boolean('active') : null;

        $query = Service::query()->with('category');
        if ($q->isNotEmpty()) {
            $query->where('name', 'like', '%'.$q.'%');
        }
        if ($categorySlug->isNotEmpty()) {
            $query->whereHas('category', fn($c) => $c->where('slug', $categorySlug));
        }
        if (!is_null($active)) {
            $query->where('is_active', $active);
        } else {
            $query->where('is_active', true);
        }

        $services = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('services.index', compact('services', 'categories'));
    }

    public function show(string $slug): View
    {
        $service = Service::with('category')->where('slug', $slug)->firstOrFail();
        return view('services.show', compact('service'));
    }
}
