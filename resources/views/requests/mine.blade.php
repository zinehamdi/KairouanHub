@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold mb-6">{{ __('requests.mine.title') }}</h1>
    <x-card class="p-0 overflow-x-auto">
        @if($jobs->count())
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 text-left">
                <tr>
                    <th class="p-2">{{ __('requests.mine.th_date') }}</th>
                    <th class="p-2">{{ __('requests.mine.th_category') }}</th>
                    <th class="p-2">{{ __('requests.mine.th_city') }}</th>
                    <th class="p-2">{{ __('requests.mine.th_status') }}</th>
                    <th class="p-2">{{ __('requests.mine.th_offers') }}</th>
                    <th class="p-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $j)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="p-2">{{ $j->created_at->format('Y-m-d') }}</td>
                        <td class="p-2">{{ $j->category?->name }} @if($j->service) / {{ $j->service?->name }} @endif</td>
                        <td class="p-2">{{ $j->city }}</td>
                        <td class="p-2"><span class="px-2 py-0.5 text-xs rounded bg-gray-200 dark:bg-gray-700">{{ __('requests.statuses.'.$j->status) }}</span></td>
                        <td class="p-2">{{ $j->offers()->count() }}</td>
                        <td class="p-2"><a href="{{ route('requests.show',$j->id) }}" class="text-indigo-600 hover:underline">{{ __('requests.show.title') }}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">{{ $jobs->links() }}</div>
        @else
            <p class="p-6 text-sm text-gray-500">{{ __('requests.mine.empty') }}</p>
        @endif
    </x-card>
</div>
@endsection
