<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

// V1 Routes
Route::prefix('v1')->group(function () {

    // Auth aliases for mobile clients
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Public Auth Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Public Data Routes
    Route::get('/categories', [App\Http\Controllers\Api\V1\CategoryController::class, 'index']);
    Route::get('/categories/{id}', [App\Http\Controllers\Api\V1\CategoryController::class, 'show']);
    Route::get('/services', [App\Http\Controllers\Api\V1\ServiceController::class, 'index']);
    Route::get('/services/{id}', [App\Http\Controllers\Api\V1\ServiceController::class, 'show']);
    Route::get('/providers', [App\Http\Controllers\Api\V1\ProviderController::class, 'index']);
    Route::get('/providers/{username}', [App\Http\Controllers\Api\V1\ProviderController::class, 'show']);

    // Localization & Homepage
    Route::get('/locales/{locale}', [App\Http\Controllers\Api\V1\LocalizationController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\Api\V1\HomeController::class, 'index']);

    // Protected Routes
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/me/profile', [App\Http\Controllers\Api\V1\MeProfileController::class, 'update']);
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/me', [AuthController::class, 'me']);
        });

        // Provider ownership
        Route::get('/my/provider', [App\Http\Controllers\Api\V1\MyProviderController::class, 'show']);
        Route::put('/my/provider', [App\Http\Controllers\Api\V1\MyProviderController::class, 'update']);

        // Community submissions
        Route::get('/me/submissions', [App\Http\Controllers\Api\V1\ProviderSubmissionController::class, 'index']);
        Route::post('/providers/submissions', [App\Http\Controllers\Api\V1\ProviderSubmissionController::class, 'store']);

        // Me: points & trust
        Route::get('/me/points', App\Http\Controllers\Api\V1\MePointsController::class);
        Route::get('/me/trust', App\Http\Controllers\Api\V1\MeTrustController::class);

        // Admin Routes
        Route::middleware(['role:admin'])->prefix('admin')->group(function () {
            Route::post('/providers/{user}/approve', [App\Http\Controllers\Api\V1\AdminController::class, 'approveProvider']);
            Route::post('/users/{user}/assign-role', [App\Http\Controllers\Api\V1\AdminController::class, 'assignRole']);

            // Moderation for provider submissions
            Route::get('/submissions', [App\Http\Controllers\Api\V1\Admin\SubmissionController::class, 'index']);
            Route::post('/submissions/{submission}/approve', [App\Http\Controllers\Api\V1\Admin\SubmissionController::class, 'approve']);
            Route::post('/submissions/{submission}/reject', [App\Http\Controllers\Api\V1\Admin\SubmissionController::class, 'reject']);
        });

        // Provider Routes
        Route::middleware(['role:provider'])->prefix('provider')->group(function () {
            Route::get('/services', [App\Http\Controllers\Api\V1\ProviderServiceController::class, 'index']);
            Route::post('/services', [App\Http\Controllers\Api\V1\ProviderServiceController::class, 'store']);
            Route::put('/services/{service}', [App\Http\Controllers\Api\V1\ProviderServiceController::class, 'update']);
            Route::delete('/services/{service}', [App\Http\Controllers\Api\V1\ProviderServiceController::class, 'destroy']);

            // Provider Requests
            Route::get('/requests', [App\Http\Controllers\Api\V1\ProviderRequestController::class, 'index']);
            Route::put('/requests/{id}/status', [App\Http\Controllers\Api\V1\ProviderRequestController::class, 'updateStatus']);
        });

        // Driver Routes
        Route::middleware(['role:driver'])->prefix('driver')->group(function () {
            Route::get('/profile', [App\Http\Controllers\Api\V1\DriverController::class, 'profile']);
            Route::put('/profile', [App\Http\Controllers\Api\V1\DriverController::class, 'updateProfile']);
            Route::put('/status', [App\Http\Controllers\Api\V1\DriverController::class, 'toggleStatus']);
            Route::put('/location', [App\Http\Controllers\Api\V1\DriverController::class, 'updateLocation']);

            // Missions
            Route::get('/missions/available', [App\Http\Controllers\Api\V1\DeliveryMissionController::class, 'index']);
            Route::get('/missions/mine', [App\Http\Controllers\Api\V1\DeliveryMissionController::class, 'myMissions']);
            Route::post('/missions/{id}/accept', [App\Http\Controllers\Api\V1\DeliveryMissionController::class, 'accept']);
            Route::put('/missions/{id}/status', [App\Http\Controllers\Api\V1\DeliveryMissionController::class, 'updateStatus']);
        });

        // User Routes (Authenticated)
        Route::get('/requests', [App\Http\Controllers\Api\V1\JobRequestBrowseController::class, 'index']);
        Route::get('/requests/mine', App\Http\Controllers\Api\V1\MyJobRequestsController::class);
        Route::post('/requests', App\Http\Controllers\Api\V1\JobRequestCreateController::class);
        Route::get('/requests/{id}', [App\Http\Controllers\Api\V1\JobRequestBrowseController::class, 'show'])->whereNumber('id');
        Route::get('/my/requests', App\Http\Controllers\Api\V1\MyJobRequestsController::class);
        Route::put('/requests/{id}/cancel', [App\Http\Controllers\Api\V1\JobRequestController::class, 'cancel'])->whereNumber('id');

        // Offers
        Route::post('/requests/{id}/offers', [App\Http\Controllers\Api\V1\OfferController::class, 'store'])->middleware(['role:provider']);
        Route::get('/my/offers', [App\Http\Controllers\Api\V1\OfferController::class, 'myOffers'])->middleware(['role:provider']);
        Route::post('/offers/{id}/accept', [App\Http\Controllers\Api\V1\OfferController::class, 'accept']);

        // Chat Routes
        Route::get('/chat/conversations', [App\Http\Controllers\Api\V1\ChatController::class, 'conversations']);
        Route::get('/chat/conversations/{id}/messages', [App\Http\Controllers\Api\V1\ChatController::class, 'messages']);
        Route::post('/chat/messages', [App\Http\Controllers\Api\V1\ChatController::class, 'sendMessage']);

        // AI Assistant
        Route::post('/assistant/chat', [App\Http\Controllers\Api\V1\AssistantController::class, 'chat']);

        // Media Upload
        Route::post('/media/upload', [App\Http\Controllers\Api\V1\MediaController::class, 'upload']);

        // Notifications
        Route::get('/notifications', [App\Http\Controllers\Api\V1\NotificationController::class, 'index']);
        Route::put('/notifications/{id}/read', [App\Http\Controllers\Api\V1\NotificationController::class, 'markAsRead']);
        Route::post('/notifications/read-all', [App\Http\Controllers\Api\V1\NotificationController::class, 'markAllAsRead']);
        Route::get('/me/notifications', [App\Http\Controllers\Api\V1\MeNotificationController::class, 'index']);
        Route::post('/me/notifications/{id}/read', [App\Http\Controllers\Api\V1\MeNotificationController::class, 'markAsRead']);

        // Future routes...
    });

});
