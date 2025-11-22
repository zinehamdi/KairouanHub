<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderOnboardingController;
use App\Http\Controllers\JobRequestController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController as PublicServiceController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use Spatie\Permission\Middleware\RoleMiddleware;



// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
// Public services
Route::get('/services', [PublicServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [PublicServiceController::class, 'show'])->name('services.show');
Route::get('/providers', [ProviderController::class, 'index'])->name('providers.index');
Route::get('/providers/{username}', [ProviderController::class, 'show'])->name('providers.show');

// Provider onboarding (auth only, no verification required)
Route::middleware(['auth'])->group(function () {
    Route::get('/become-a-provider', [ProviderOnboardingController::class, 'start'])->name('provider.start');
    Route::post('/become-a-provider', [ProviderOnboardingController::class, 'store'])->name('provider.store');
    Route::get('/provider/setup/services', [ProviderOnboardingController::class, 'services'])->name('provider.services');
    Route::post('/provider/setup/services', [ProviderOnboardingController::class, 'storeServices'])->name('provider.services.store');
    Route::get('/provider/setup/photos', [ProviderOnboardingController::class, 'photos'])->name('provider.photos');
    Route::post('/provider/setup/photos', [ProviderOnboardingController::class, 'storePhotos'])->name('provider.photos.store');
    Route::get('/provider/dashboard', [ProviderOnboardingController::class, 'dashboard'])->name('provider.dashboard');
});
// Health check
Route::get('/healthz', [HomeController::class, 'healthz']);

// Language switcher
Route::post('/lang/switch', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth', 'throttle:20,1'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';

// Job Requests & Offers (authenticated only)
Route::middleware(['auth'])->group(function () {
    // Job Requests
    Route::get('/requests/create', [JobRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [JobRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/mine', [JobRequestController::class, 'myRequests'])->name('requests.mine');
    Route::get('/requests/{id}', [JobRequestController::class, 'show'])->name('requests.show');

    // Offers
    Route::post('/requests/{id}/offers', [OfferController::class, 'store'])->name('offers.store');
    Route::put('/offers/{id}', [OfferController::class, 'update'])->name('offers.update');
    Route::post('/offers/{id}/accept', [OfferController::class, 'accept'])->name('offers.accept');
});

// Admin routes — مشرف
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', RoleMiddleware::class . ':admin'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('services', AdminServiceController::class);
    });

