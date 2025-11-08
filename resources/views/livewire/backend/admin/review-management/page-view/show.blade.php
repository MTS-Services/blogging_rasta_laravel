<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Page View Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.rm.review.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 min-h-[500px]">

        {{-- Main Info Header --}}
        <div class="flex items-start gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
            <div
                class="flex-shrink-0 w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>

            <div class="flex-1">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ class_basename($data->viewable_type) }} #{{ $data->viewable_id }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ __('Viewed on') }} {{ $data->created_at->format('d M Y, h:i A') }}
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            {{-- Viewable Type --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Viewable Type') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ class_basename($data->viewable_type) }}
                </p>
            </div>

            {{-- Viewable ID --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Viewable ID') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->viewable_id }}
                </p>
            </div>

            {{-- Viewer Type --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Viewer Type') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->viewer_type ? class_basename($data->viewer_type) : 'Guest' }}
                </p>
            </div>

            {{-- Viewer ID --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Viewer ID') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->viewer_id ?? 'N/A' }}
                </p>
            </div>

            {{-- IP Address --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('IP Address') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->ip_address }}
                </p>
            </div>

            {{-- Sort Order --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Sort Order') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->sort_order }}
                </p>
            </div>

            {{-- Created Date --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created Date') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->created_at_formatted }}
                </p>
            </div>

            {{-- Updated Date --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Updated Date') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->updated_at_formatted ?? 'N/A' }}
                </p>
            </div>

            {{-- Deleted Date --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Deleted Date') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->deleted_at_formatted ?? 'N/A' }}
                </p>
            </div>

            {{-- Created By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created By') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->creater_admin?->name ?? 'System' }}
                </p>
            </div>

            {{-- Updated By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Updated By') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->updater_admin?->name ?? 'N/A' }}
                </p>
            </div>

            {{-- Deleted By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Deleted By') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->deleter_admin?->name ?? 'N/A' }}
                </p>
            </div>

        </div>

        {{-- User Agent Section --}}
        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('User Agent') }}</h4>
            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                <p class="font-mono text-sm text-gray-700 dark:text-gray-300 break-all">
                    {{ $data->user_agent ?? 'N/A' }}
                </p>
            </div>
        </div>

        {{-- Referrer Section --}}
        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('Referrer') }}</h4>
            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                @if ($data->referrer)
                    <a href="{{ $data->referrer }}" target="_blank"
                        class="font-mono text-sm text-blue-600 dark:text-blue-400 hover:underline break-all">
                        {{ $data->referrer }}
                    </a>
                @else
                    <p class="font-mono text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Direct / No Referrer') }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Viewable Content Preview (Optional) --}}
        @if ($data->viewable)
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('Viewed Content') }}</h4>
                <div
                    class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-blue-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ __('Title/Name') }}:</p>
                    <p class="font-semibold text-gray-900 dark:text-white">
                        {{ $data->viewable->title ?? ($data->viewable->name ?? 'N/A') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Viewer Info (Optional) --}}
        @if ($data->viewer)
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('Viewer Information') }}</h4>
                <div
                    class="bg-gradient-to-br from-green-50 to-teal-50 dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border border-green-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ __('Name') }}:</p>
                    <p class="font-semibold text-gray-900 dark:text-white">
                        {{ $data->viewer->name ?? 'N/A' }}
                    </p>
                    @if (isset($data->viewer->email))
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-3 mb-2">{{ __('Email') }}:</p>
                        <p class="font-mono text-sm text-gray-900 dark:text-white">
                            {{ $data->viewer->email }}
                        </p>
                    @endif
                </div>
            </div>
        @endif

    </div>
</div>
