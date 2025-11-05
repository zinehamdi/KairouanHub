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

    /** Index listing with filters (to be expanded later) */
    public function index(Request $request)
    {
        $filters = $request->only(['q','city','category','badge','rating']);
        $providers = $this->repo->paginateApproved($filters, 12);
        return view('providers.index', compact('providers','filters'));
    }

    /** Show by username or id fallback */
    public function show(Request $request, string $username)
    {
        $user = $request->user();
        $profile = $this->repo->findByUsernameOrId($username);
        if(!$profile) {
            // try public approved only
            $profile = $this->repo->findPublicByUsernameOrId($username);
        }
        if(!$profile) abort(404);

        $isOwnerOrAdmin = $user && ($user->id === $profile->user_id || $user->hasRole('admin'));
        if($profile->status !== 'approved' && !$isOwnerOrAdmin) {
            abort(404);
        }
        $profile->load(['user','services']);
        return view('providers.show', compact('profile'));
    }
}
