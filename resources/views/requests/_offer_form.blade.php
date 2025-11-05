@if($job->status === 'open')
<x-card class="p-6 mt-4">
    <h2 class="font-semibold mb-4">{{ $offer ? __('offers.form.update_offer') : __('offers.form.submit_offer') }}</h2>
    <form method="POST" action="{{ $offer ? route('offers.update',$offer->id) : route('offers.store',$job->id) }}" class="space-y-4">
        @csrf
        @if($offer) @method('PUT') @endif
        <div>
            <label class="block text-sm font-medium">{{ __('offers.form.price') }}</label>
            <input type="number" name="price" value="{{ old('price',$offer->price ?? '') }}" class="mt-1 w-full border rounded p-2" />
        </div>
        <div>
            <label class="block text-sm font-medium">{{ __('offers.form.eta_days') }}</label>
            <input type="number" name="eta_days" value="{{ old('eta_days',$offer->eta_days ?? '') }}" class="mt-1 w-full border rounded p-2" />
        </div>
        <div>
            <label class="block text-sm font-medium">{{ __('offers.form.note') }}</label>
            <textarea name="note" rows="3" class="mt-1 w-full border rounded p-2">{{ old('note',$offer->note ?? '') }}</textarea>
        </div>
    <p class="text-xs text-gray-500">{{ __('offers.form.notice_one_offer') ?: 'One active offer per provider per request.' }}</p>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">{{ $offer ? __('offers.form.update_offer') : __('offers.form.submit_offer') }}</button>
    </form>
</x-card>
@endif