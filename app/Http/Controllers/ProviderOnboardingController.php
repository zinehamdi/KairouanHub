<?php

namespace App\Http\Controllers;

use App\Infrastructure\Http\Requests\Onboarding\StoreProfileRequest;
use App\Infrastructure\Http\Requests\Onboarding\StoreServicesRequest;
use App\Infrastructure\Http\Requests\Onboarding\StorePhotosRequest;
use Domain\Providers\Repositories\ProviderProfileRepositoryInterface;
use App\Models\ProviderProfile;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProviderOnboardingSubmitted;
use App\Notifications\NewProviderPendingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * EN: Handles multi-step provider onboarding.
 * AR: إدارة خطوات تسجيل المزود.
 */
class ProviderOnboardingController extends Controller
{
    public function __construct(private ProviderProfileRepositoryInterface $repo)
    {
        $this->middleware(['auth']);
    }

    public function start()
    {
        $this->authorize('create', ProviderProfile::class);
        $auto = config('appsettings.providers.auto_approve');
        $categories = \App\Models\Category::orderBy('position')->get(['id', 'name', 'description']);
        return view('provider_onboarding.step1_info', compact('auto', 'categories'));
    }

    public function store(StoreProfileRequest $request)
    {
        $this->authorize('create', ProviderProfile::class);
        $data = $request->validated();
        // Normalize arrays -> *_json columns expected
        $payload = [
            'category_id' => $data['category_id'],
            'display_name' => $data['display_name'],
            'city' => $data['city'],
            'bio' => $data['bio'] ?? null,
            'website' => $data['website'] ?? null,
            'skills_json' => $data['skills'] ?? [],
            'cities_json' => $data['cities'] ?? [],
            'social_json' => $data['social'] ?? [],
            'status' => config('appsettings.providers.auto_approve') ? 'approved' : 'pending',
        ];
        $profile = $this->repo->createForUser(Auth::id(), $payload);
        if($profile->status === 'pending') {
            $user = Auth::user();
            Notification::send($user, new ProviderOnboardingSubmitted($profile));
            $admins = \App\Models\User::role('admin')->get();
            Notification::send($admins, new NewProviderPendingApproval($profile));
        }
        return redirect()->route('provider.services')->with('success', __('messages.saved'));
    }

    public function services(): View
    {
        $profile = $this->myProfileOrFail();
        $this->authorize('update', $profile);
        
        // If profile has a category, show only that category's services
        // Otherwise show all categories
        if ($profile->category_id) {
            $categories = \App\Models\Category::with('services')
                ->where('id', $profile->category_id)
                ->orderBy('position')
                ->get();
        } else {
            $categories = \App\Models\Category::with('services')->orderBy('position')->get();
        }
        
        return view('provider_onboarding.step2_services', compact('profile','categories'));
    }

    public function storeServices(StoreServicesRequest $request): RedirectResponse
    {
        $profile = $this->repo->findByUserId(auth()->id());
        if (!$profile) {
            return redirect()->route('provider.start')->withErrors('Profile not found');
        }

        $this->repo->syncServices($profile, $request->validated('services'));

        return redirect()->route('provider.photos');
    }

    public function photos()
    {
        $profile = $this->myProfileOrFail();
        $this->authorize('update', $profile);
        $max = config('appsettings.providers.max_gallery',6);
        return view('provider_onboarding.step3_photos', compact('profile','max'));
    }

    public function storePhotos(StorePhotosRequest $request)
    {
        $profile = $this->myProfileOrFail();
        $this->authorize('update', $profile);
        $paths = [];
        foreach ($request->file('photos') as $file) {
            $paths[] = $file->storeAs('providers/'.Auth::id().'/gallery', Str::uuid().'.'.$file->getClientOriginalExtension(), 'public');
        }
        $this->repo->appendPhotos($profile, $paths, config('appsettings.providers.max_gallery',6));
        return redirect()->route('provider.dashboard')->with('success', __('messages.uploaded'));
    }

    public function dashboard()
    {
        $profile = $this->repo->findByUserId(Auth::id());
        return view('provider_onboarding.dashboard', compact('profile'));
    }

    private function myProfileOrFail(): ProviderProfile
    {
        $profile = $this->repo->findByUserId(Auth::id());
        abort_if(!$profile, 404);
        return $profile;
    }
}
