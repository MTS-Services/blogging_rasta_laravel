<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Product Type Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.pm.productType.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 min-h-[500px]">
        <div class="flex items-start gap-4 mb-6">
            {{-- Icon Display --}}
            @if ($data->icon)
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . $data->icon) }}" alt="{{ $data->name }}"
                        class="w-16 h-16 rounded-lg object-cover border-2 border-gray-200 dark:border-gray-700">
                </div>
            @endif

            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $data->name }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $data->slug }}</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            {{-- Name --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Name') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->name }}
                </p>
            </div>

            {{-- Slug --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Slug') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->slug }}
                </p>
            </div>

            {{-- Commission Rate --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Commission Rate') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->commission_rate ? number_format($data->commission_rate, 2) . '%' : 'N/A' }}
                </p>
            </div>

            {{-- Requires Delivery Time --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Requires Delivery Time') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->requires_delivery_time ?? 'N/A' }}
                </p>
            </div>

            {{-- requires_server_info --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Requires Server Info') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->requires_server_info ?? 'N/A' }}
                </p>
            </div>

            {{-- requires_character_info --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Requires qharacter Info') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->requires_character_info ?? 'N/A' }}
                </p>
            </div>

            {{-- max_delivery_time_hours --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Max Delivery Time Hours') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->max_delivery_time_hours ?? 'N/A' }}
                </p>
            </div>

            {{-- Status --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Status') }}</p>
                <span
                    class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->status->color() }}">
                    {{ $data->status->label() }}
                </span>
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

            {{-- Icon Path --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Icon') }}</p>
                <p class="font-mono text-sm text-gray-900 dark:text-white break-all">
                    {{ $data->icon ? basename($data->icon) : 'N/A' }}
                </p>
            </div>

            {{-- Created By --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created By') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->creater_admin?->name ?? 'N/A' }}
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
        {{-- Description Section --}}
        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ __('Description') }}</h4>
            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                {!! $data->description !!}
            </div>
        </div>
    </div>
</div>
