<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends BaseApiController
{
	/**
	 * Approve a provider's onboarding request.
	 */
	public function approveProvider(User $user)
	{
		// Ensure user has a provider profile
		$profile = $user->providerProfile;

		if (!$profile) {
			return $this->errorResponse('User does not have a provider profile.', 404);
		}

		if ($profile->status === 'approved') {
			return $this->errorResponse('Provider is already approved.', 400);
		}

		// Update profile status
		$profile->update(['status' => 'approved']);

		// Assign 'provider' role if not already assigned
		if (!$user->hasRole('provider')) {
			$user->assignRole('provider');
		}

		return $this->successResponse(null, 'Provider approved successfully.');
	}

	/**
	 * Assign a role to a user.
	 */
	public function assignRole(Request $request, User $user)
	{
		$request->validate([
			'role' => 'required|exists:roles,name',
		]);

		$role = $request->role;

		if ($user->hasRole($role)) {
			return $this->errorResponse("User already has the role '{$role}'.", 400);
		}

		$user->assignRole($role);

		return $this->successResponse(null, "Role '{$role}' assigned successfully.");
	}
}
