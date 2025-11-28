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
        // Allow users to view the form even if they have a profile (they can update it)
        $auto = config('appsettings.providers.auto_approve');
        $categories = \App\Models\Category::orderBy('position')->get(['id', 'name', 'description']);
        return view('provider_onboarding.step1_info', compact('auto', 'categories'));
    }

    public function store(StoreProfileRequest $request)
    {
        $data = $request->validated();
        
        // Check if user already has a profile
        $existingProfile = $this->repo->findByUserId(Auth::id());
        
        if ($existingProfile) {
            // User already has a profile, skip to services step
            return redirect()->route('provider.services')->with('info', 'Profile already exists. You can update your services.');
        }
        
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
        
        // Create new profile
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
        
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Generate unique filename with .webp extension
                $filename = Str::uuid() . '.webp';
                $path = 'providers/' . Auth::id() . '/gallery/' . $filename;
                
                // Resize and convert to WebP
                $this->resizeAndSaveImage($file, $path);
                
                $paths[] = $path;
            }
        }
        
        $this->repo->appendPhotos($profile, $paths, config('appsettings.providers.max_gallery', 6));
        return redirect()->route('provider.dashboard')->with('success', __('messages.uploaded'));
    }

    private function resizeAndSaveImage($file, $path)
    {
        list($width, $height) = getimagesize($file);
        $maxWidth = 1024;
        
        if ($width > $maxWidth) {
            $ratio = $maxWidth / $width;
            $newWidth = $maxWidth;
            $newHeight = $height * $ratio;
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }
        
        $src = imagecreatefromstring(file_get_contents($file));
        $dst = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG/WEBP
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Save to storage
        $fullPath = storage_path('app/public/' . $path);
        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($dst, $fullPath, 85);
                break;
            case 'png':
                imagepng($dst, $fullPath, 8);
                break;
            case 'webp':
                imagewebp($dst, $fullPath, 85);
                break;
            default:
                // Fallback for others or just copy
                imagejpeg($dst, $fullPath, 85);
        }
        
        imagedestroy($src);
        imagedestroy($dst);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'file', 'image', 'max:10240'],
        ]);

        $profile = $this->myProfileOrFail();
        $this->authorize('update', $profile);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $file = $request->file('avatar');
            // Always convert to webp for consistency
            $filename = Str::uuid() . '.webp';
            $path = 'providers/' . Auth::id() . '/avatar/' . $filename;
            $this->resizeAndSaveAvatarWebp($file, $path);
            $profile->update(['avatar' => $path]);
        }

        return redirect()->route('provider.dashboard')->with('success', 'Profile photo updated successfully!');
    }

    private function resizeAndSaveAvatarWebp($file, $path)
    {
        list($width, $height) = getimagesize($file);
        $size = 256;

        $src = imagecreatefromstring(file_get_contents($file));
        $dst = imagecreatetruecolor($size, $size);

        // Preserve transparency
        imagealphablending($dst, false);
        imagesavealpha($dst, true);

        // Calculate crop dimensions for square
        $minDim = min($width, $height);
        $srcX = ($width - $minDim) / 2;
        $srcY = ($height - $minDim) / 2;

        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $size, $size, $minDim, $minDim);

        // Encode to WEBP binary and store via Storage (supports testing fakes)
        ob_start();
        imagewebp($dst, null, 90);
        $binary = ob_get_clean();
        Storage::disk('public')->put($path, $binary);

        imagedestroy($src);
        imagedestroy($dst);
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
