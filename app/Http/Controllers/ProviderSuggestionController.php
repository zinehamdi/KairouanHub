<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ProviderSubmissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderSuggestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the provider suggestion wizard form.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('position')
            ->get(['id', 'name', 'name_ar']);

        return view('providers.suggest', compact('categories'));
    }

    /**
     * Store a new provider suggestion.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_name' => 'required|string|max:255',
            'phone' => 'required|string|max:32',
            'category_id' => 'nullable|exists:categories,id',
            'city' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $submissionService = app(ProviderSubmissionService::class);
            $submission = $submissionService->create($validated, Auth::user());

            return redirect()->route('dashboard')
                ->with('success', __('wizard.suggest.success_message'));

        } catch (\RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
