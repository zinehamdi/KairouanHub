<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('services.manage') }}
        </h2>
    </x-slot>

    <x-flash />

    <div class="max-w-7xl mx-auto py-6">
        <div class="mb-4">
            <a href="{{ route('admin.services.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">{{ __('buttons.create') }}</a>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('services.name') }}</th>
                        <th class="px-6 py-3">{{ __('categories.name') }}</th>
                        <th class="px-6 py-3">{{ __('buttons.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($services as $service)
                        <tr>
                            <td class="px-6 py-4">{{ $service->id }}</td>
                            <td class="px-6 py-4">{{ e($service->name) }}</td>
                            <td class="px-6 py-4">{{ e($service->category->name ?? '-') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.services.edit', $service) }}" class="text-indigo-600">{{ __('buttons.edit') }}</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 ml-2" onclick="return confirm('{{ __('messages.confirm_delete') }}')">{{ __('buttons.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $services->links() }}</div>
    </div>
</x-app-layout>
