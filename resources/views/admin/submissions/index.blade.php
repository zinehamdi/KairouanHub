@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-kairouan-warm-cream py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-brand-dark mb-2">{{ __('submissions.title') }}</h1>
                <p class="text-gray-600">{{ __('submissions.subtitle') }}</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center px-6 py-3 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105"
               style="background: linear-gradient(135deg, #264653 0%, #3D5A80 100%);">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('submissions.back_to_dashboard') }}
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Status Filter -->
        <div class="mb-6 flex gap-3">
            <a href="{{ route('admin.submissions.index', ['status' => 'all']) }}" 
               class="px-4 py-2 rounded-lg {{ $status === 'all' ? 'bg-terracotta text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                {{ __('submissions.filters.all') }} ({{ \App\Models\ProviderSubmission::count() }})
            </a>
            <a href="{{ route('admin.submissions.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg {{ $status === 'pending' ? 'bg-terracotta text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                {{ __('submissions.filters.pending') }}
                @if($pendingCount > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1 ml-2">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.submissions.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-lg {{ $status === 'approved' ? 'bg-terracotta text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                {{ __('submissions.filters.approved') }}
            </a>
            <a href="{{ route('admin.submissions.index', ['status' => 'rejected']) }}" 
               class="px-4 py-2 rounded-lg {{ $status === 'rejected' ? 'bg-terracotta text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                {{ __('submissions.filters.rejected') }}
            </a>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            @if($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Provider Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">City</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Submitted By</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Submitted At</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $submission->provider_name }}</div>
                                        @if($submission->description)
                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($submission->description, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $submission->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $submission->category->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $submission->city ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $submission->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $submission->user->email ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($submission->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                        @if($submission->reviewed_by)
                                            <div class="text-xs text-gray-500 mt-1">
                                                Reviewed by: {{ $submission->reviewer->name ?? 'N/A' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $submission->created_at->format('M d, Y') }}
                                        <div class="text-xs">{{ $submission->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($submission->status === 'pending')
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.submissions.show', $submission) }}" 
                                                   class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    ✏️ Review
                                                </a>
                                                <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-900 font-semibold"
                                                            onclick="return confirm('Approve this provider suggestion?');">
                                                        ✅ Approve
                                                    </button>
                                                </form>
                                                <button onclick="showRejectModal({{ $submission->id }})" 
                                                        class="text-red-600 hover:text-red-900 font-semibold">
                                                    ❌ Reject
                                                </button>
                                            </div>
                                        @else
                                            @if($submission->rejection_reason)
                                                <div class="text-xs text-red-600">
                                                    Reason: {{ Str::limit($submission->rejection_reason, 30) }}
                                                </div>
                                            @endif
                                            <div class="text-xs text-gray-500">
                                                {{ $submission->reviewed_at ? $submission->reviewed_at->format('M d, Y') : '' }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $submissions->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No submissions found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if($status === 'pending')
                            There are no pending provider suggestions to review.
                        @else
                            No {{ $status }} submissions found.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold mb-4">Reject Provider Suggestion</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Rejection Reason</label>
                <textarea name="reason" required rows="4" 
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-terracotta focus:border-terracotta"
                          placeholder="Please provide a reason for rejecting this suggestion..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-terracotta flex-1">Reject</button>
                <button type="button" onclick="closeRejectModal()" class="btn-outline-mediterranean flex-1">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(submissionId) {
    document.getElementById('rejectForm').action = '{{ route("admin.submissions.reject", ":id") }}'.replace(':id', submissionId);
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}
</script>
@endsection
