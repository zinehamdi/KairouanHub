<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProviderSubmission;
use App\Services\ModerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class SubmissionController extends Controller
{
    public function __construct(
        private ModerationService $moderationService
    ) {
    }

    /**
     * Display a listing of provider submissions.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $query = ProviderSubmission::with(['user', 'category', 'reviewer'])
            ->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $submissions = $query->paginate(20);

        $pendingCount = ProviderSubmission::where('status', 'pending')->count();

        return view('admin.submissions.index', compact('submissions', 'status', 'pendingCount'));
    }

    /**
     * Show a single submission for review/editing.
     */
    public function show(ProviderSubmission $submission)
    {
        $submission->load(['user', 'category', 'reviewer']);
        $categories = Category::orderBy('name')->get();
        
        return view('admin.submissions.show', compact('submission', 'categories'));
    }

    /**
     * Update a submission's details before approving.
     */
    public function update(Request $request, ProviderSubmission $submission)
    {
        if ($submission->status !== 'pending') {
            return back()->with('error', 'Cannot edit a submission that has already been reviewed.');
        }

        $validated = $request->validate([
            'provider_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'category_id' => 'required|exists:categories,id',
            'city' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $submission->update($validated);

        return back()->with('success', 'Submission details updated successfully!');
    }

    /**
     * Approve a provider submission.
     */
    public function approve(ProviderSubmission $submission)
    {
        try {
            $this->moderationService->approve($submission, Auth::user());

            return redirect()->route('admin.submissions.index')
                ->with('success', 'Provider suggestion approved successfully!');
        } catch (\RuntimeException $e) {
            return redirect()->route('admin.submissions.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Reject a provider submission.
     */
    public function reject(Request $request, ProviderSubmission $submission)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            $this->moderationService->reject($submission, Auth::user(), $request->reason);

            return redirect()->route('admin.submissions.index')
                ->with('success', 'Provider suggestion rejected.');
        } catch (\RuntimeException $e) {
            return redirect()->route('admin.submissions.index')
                ->with('error', $e->getMessage());
        }
    }
}