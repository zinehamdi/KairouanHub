<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProviderProfile;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = ProviderProfile::with(['user', 'services'])
            ->latest()
            ->paginate(20);

        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
        $services = Service::with('category')->get()->groupBy('category.name');
        return view('admin.providers.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'email_verified_at' => now(),
            ]);

            // Assign provider role
            $user->assignRole('provider');

            // Create provider profile
            $profile = ProviderProfile::create([
                'user_id' => $user->id,
                'phone' => $validated['phone'],
                'bio' => $validated['bio'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? 'Kairouan',
                'is_approved' => true,
                'approved_at' => now(),
            ]);

            // Attach services
            $serviceData = [];
            foreach ($validated['services'] as $serviceId) {
                $serviceData[$serviceId] = [
                    'price_min' => $request->input("price_min.{$serviceId}", 50),
                    'price_max' => $request->input("price_max.{$serviceId}", 200),
                ];
            }
            $profile->services()->attach($serviceData);

            DB::commit();

            return redirect()->route('admin.providers.index')
                ->with('success', 'Provider created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create provider: ' . $e->getMessage());
        }
    }

    public function show(ProviderProfile $provider)
    {
        $provider->load(['user', 'services.category', 'reviews']);
        return view('admin.providers.show', compact('provider'));
    }

    public function edit(ProviderProfile $provider)
    {
        $services = Service::with('category')->get()->groupBy('category.name');
        $provider->load(['user', 'services']);
        return view('admin.providers.edit', compact('provider', 'services'));
    }

    public function update(Request $request, ProviderProfile $provider)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $provider->user_id,
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'is_approved' => 'boolean',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $provider->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update password if provided
            if ($request->filled('password')) {
                $request->validate(['password' => 'string|min:8|confirmed']);
                $provider->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Update provider profile
            $provider->update([
                'phone' => $validated['phone'],
                'bio' => $validated['bio'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? 'Kairouan',
                'is_approved' => $validated['is_approved'] ?? $provider->is_approved,
                'approved_at' => $validated['is_approved'] && !$provider->is_approved ? now() : $provider->approved_at,
            ]);

            // Sync services
            $serviceData = [];
            foreach ($validated['services'] as $serviceId) {
                $serviceData[$serviceId] = [
                    'price_min' => $request->input("price_min.{$serviceId}", 50),
                    'price_max' => $request->input("price_max.{$serviceId}", 200),
                ];
            }
            $provider->services()->sync($serviceData);

            DB::commit();

            return redirect()->route('admin.providers.index')
                ->with('success', 'Provider updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update provider: ' . $e->getMessage());
        }
    }

    public function destroy(ProviderProfile $provider)
    {
        DB::beginTransaction();
        try {
            $user = $provider->user;
            $provider->services()->detach();
            $provider->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('admin.providers.index')
                ->with('success', 'Provider deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete provider: ' . $e->getMessage());
        }
    }

    public function approve(ProviderProfile $provider)
    {
        $provider->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Provider approved successfully!');
    }

    public function reject(ProviderProfile $provider)
    {
        $provider->update([
            'is_approved' => false,
            'approved_at' => null,
        ]);

        return back()->with('success', 'Provider rejected successfully!');
    }
}
