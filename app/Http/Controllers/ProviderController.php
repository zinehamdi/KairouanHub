<?php

namespace App\Http\Controllers;

use App\Models\ProviderProfile;
use App\Models\User;
use Domain\Providers\Repositories\ProviderProfileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * EN: Public provider directory controller.
 * AR: متحكم الدليل العام للمزودين.
 */
class ProviderController extends Controller
{
    public function __construct(private ProviderProfileRepositoryInterface $repo) {}

    /** 
     * Index listing with filters.
     * Service-first: if no context (search, service, category), redirect to services.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['q', 'city', 'category', 'service', 'badge', 'rating']);
        
        // Service-first: require search context or filter
        $hasContext = !empty($filters['q']) || !empty($filters['service']) || !empty($filters['category']);
        
        if (!$hasContext) {
            return redirect()->route('services.index')
                ->with('info', __('common.browse_services_first'));
        }
        
        $providers = $this->repo->paginateApproved($filters, 12);
        return view('providers.index', compact('providers', 'filters'));
    }

    /** Show provider public profile */
    public function show(ProviderProfile $provider)
    {
        // Ensure provider is approved or viewer is admin/owner
        $user = auth()->user();
        $isOwnerOrAdmin = $user && ($user->id === $provider->user_id || $user->hasRole('admin'));
        
        if ($provider->status !== 'approved' && !$isOwnerOrAdmin) {
            abort(404);
        }

        $provider->load(['user', 'services.category', 'category']);
        
        return view('providers.show', compact('provider'));
    }
}
