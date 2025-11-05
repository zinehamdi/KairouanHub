<?php

namespace App\Http\Controllers;

use App\Infrastructure\Http\Requests\Jobs\StoreOfferRequest;
use App\Models\JobRequest;
use App\Models\Offer;
use App\Notifications\NewOfferNotification;
use App\Notifications\OfferAcceptedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

/** EN: Handles provider offers. AR: إدارة عروض المزودين */
class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function store(StoreOfferRequest $request, $id)
    {
        $job = JobRequest::findOrFail($id);
        $this->authorize('view', $job); // provider must at least view
        $this->authorize('create', Offer::class);
        $provider = Auth::user()->providerProfile;
        // Prevent duplicate
        if (Offer::where('request_id',$job->id)->where('provider_id',$provider->id)->exists()) {
            return back()->with('error','Already offered');
        }
        $offer = Offer::create([
            'request_id' => $job->id,
            'provider_id' => $provider->id,
            'note' => $request->validated('note'),
            'eta_days' => $request->validated('eta_days'),
            'price' => $request->validated('price'),
            'status' => 'pending'
        ]);
        Notification::send($job->client, new NewOfferNotification($offer));
        return back()->with('success', __('messages.created'));
    }

    public function update(StoreOfferRequest $request, $id)
    {
        $offer = Offer::with('request')->findOrFail($id);
        $this->authorize('update', $offer);
        $offer->update($request->validated());
        return back()->with('success', __('messages.updated'));
    }

    public function accept($id)
    {
        $offer = Offer::with('request','provider')->findOrFail($id);
        $job = $offer->request;
        // Only owner can accept
        if ($job->client_id !== Auth::id()) { abort(403); }
        if ($job->status !== 'open') { return back()->with('error','Already matched'); }

        // Accept this offer, reject others, mark job matched
        $offer->update(['status' => 'accepted']);
        Offer::where('request_id',$job->id)->where('id','!=',$offer->id)->update(['status' => 'rejected']);
        $job->update(['status' => 'matched']);
        Notification::send($offer->provider->user, new OfferAcceptedNotification($offer));
        return back()->with('success', __('messages.updated'));
    }
}
