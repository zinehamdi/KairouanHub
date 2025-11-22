<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends BaseApiController
{
	/**
	 * Register a new user.
	 */
	public function register(Request $request)
	{
		$request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
			'password' => ['required', 'confirmed', Rules\Password::defaults()],
			'phone' => ['nullable', 'string', 'max:20'], // Optional phone
		]);

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'phone' => $request->phone ?? null,
		]);

		// Assign default role if needed, e.g., 'user'
		// $user->assignRole('user');

		$token = $user->createToken('auth_token')->plainTextToken;

		return $this->successResponse([
			'user' => new UserResource($user),
			'token' => $token,
		], 'User registered successfully', 201);
	}

	/**
	 * Login user and create token.
	 */
	public function login(Request $request)
	{
		$request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		if (!Auth::attempt($request->only('email', 'password'))) {
			return $this->errorResponse('Invalid login credentials', 401);
		}

		$user = User::where('email', $request->email)->firstOrFail();
		$token = $user->createToken('auth_token')->plainTextToken;

		return $this->successResponse([
			'user' => new UserResource($user),
			'token' => $token,
		], 'Login successful');
	}

	/**
	 * Logout user (revoke token).
	 */
	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();

		return $this->successResponse(null, 'Logged out successfully');
	}

	/**
	 * Get authenticated user details.
	 */
	public function me(Request $request)
	{
		return $this->successResponse(new UserResource($request->user()));
	}
}
