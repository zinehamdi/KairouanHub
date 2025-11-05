<?php

namespace App\Http\Controllers;

use App\Infrastructure\Http\Requests\Jobs\StoreJobRequestRequest;
use App\Models\JobRequest;
use App\Models\Category;
use App\Models\Service;
use App\Models\ProviderProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewJobRequestNotification;
use Illuminate\Http\Request;

/** EN: Handles client job request lifecycle. AR: إدارة دورة حياة طلبات الخدمة للعميل */
class JobRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function create()
    {
        $this->authorize('create', JobRequest::class);
        $categories = Category::query()->orderBy('name')->get(['id','name']);
        return view('requests.create', compact('categories'));
    }

    public function store(StoreJobRequestRequest $request)
    {
        $this->authorize('create', JobRequest::class);
        $data = $request->validated();
        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Use store on public disk so Storage::fake('public') works in tests
                $photos[] = $file->store('requests/'.Auth::id(), 'public');
            }
        }
        $job = JobRequest::create([
            'client_id' => Auth::id(),
            'category_id' => $data['category_id'],
            'service_id' => $data['service_id'] ?? null,
            'details' => $data['details'],
            'photos_json' => $photos,
            'city' => $data['city'],
            'status' => 'open'
        ]);

        // Notify approved providers who offer the requested service in the same city
        $providers = ProviderProfile::query()
            ->where('status','approved')
            ->where('city', $job->city)
            ->when($job->service_id, function($q) use ($job) {
                // Filter providers who offer this specific service
                $q->whereHas('services', fn($sq) => $sq->where('service_id', $job->service_id));
            })
            ->get();
        Notification::send($providers, new NewJobRequestNotification($job));

        return redirect()->route('requests.show', $job->id)->with('success', __('messages.created'));
    }

    public function show($id)
    {
        $job = JobRequest::with(['category','service','offers.provider.user'])->findOrFail($id);
        $this->authorize('view', $job);
        $isOwner = $job->client_id === Auth::id();
        return view('requests.show', compact('job','isOwner'));
    }

    public function myRequests()
    {
        $jobs = JobRequest::where('client_id', Auth::id())->latest()->paginate(15);
        return view('requests.mine', compact('jobs'));
    }
}
