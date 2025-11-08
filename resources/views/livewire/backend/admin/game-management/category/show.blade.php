<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Category View') }}</h2>
            <div class="flex items-center gap-2">
                {{-- <x-ui.button href="{{ route('admin.am.admin.trash') }}" type='secondary'>
                    <flux:icon name="trash" class="w-4 h-4 stroke-white" />
                    {{ __('Trash') }}
                </x-ui.button> --}}
                {{-- <x-ui.button href="{{ route('admin.am.admin.create') }}">
                    <flux:icon name="user-plus" class="w-4 h-4 stroke-white" />
                    {{ __('Add') }}
                </x-ui.button>  --}}
                <x-ui.button href="{{ route('admin.gm.category.index') }}" type='accent' class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="container  mx-auto bg-white dark:bg-gray-900 shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
            Game Category Details
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- ID -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('ID') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->id }}</p>
            </div>

            <!-- Sort Order -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Sort Order') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->sort_order ?? 0 }}</p>
            </div>

            <!-- Name -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Name') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->name }}</p>
            </div>

            <!-- Slug -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Slug') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->slug }}</p>
            </div>

            <!-- Meta Title -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Meta Title') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->meta_title ?? 'N/A' }}</p>
            </div>

            <!-- Meta Description -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Meta Description') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->meta_description ?? 'N/A' }}</p>
            </div>

            <!-- Icon -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Icon') }}</p>
                @if ($data->icon)
                    <img src="{{ asset('storage/' . $data->icon) }}" alt="Icon"
                        class="w-16 h-16 rounded-md border mt-2">
                @else
                    <p class="text-gray-500">No Icon</p>
                @endif
            </div>

            <!-- Is Featured -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Is Featured') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">
                    {{ $data->is_featured ? 'Yes' : 'No' }}
                </p>
            </div>

            <!-- Status -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Status') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white capitalize">{{ $data->status->value }}</p>
            </div>

            <!-- Created By -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created By') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->created_by ?? 'N/A' }}</p>
            </div>

            <!-- Updated By -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Updated By') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->updated_by ?? 'N/A' }}</p>
            </div>

            <!-- Deleted By -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Deleted By') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->deleted_by ?? 'N/A' }}</p>
            </div>

            <!-- Restored By -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Restored By') }}</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $data->restored_by ?? 'N/A' }}</p>
            </div>

            <!-- Created At -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Created At') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->created_at ? $data->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                </p>
            </div>

            <!-- Updated At -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Updated At') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->updated_at ? $data->updated_at->format('Y-m-d H:i:s') : 'N/A' }}
                </p>
            </div>

            <!-- Deleted At -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Deleted At') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->deleted_at ? $data->deleted_at->format('Y-m-d H:i:s') : 'N/A' }}
                </p>
            </div>

            <!-- Restored At -->
            <div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Restored At') }}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white">
                    {{ $data->restored_at ? $data->restored_at->format('Y-m-d H:i:s') : 'N/A' }}
                </p>
            </div>
        </div>

        <!-- Description Block -->
        <div class="mt-6">
            <p class="text-gray-500 dark:text-gray-400">{{ __('Description') }}</p>
            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-md text-gray-900 dark:text-white">
                {!! nl2br(e($data->description)) ?? 'N/A' !!}
            </div>
        </div>
    </div>





</section>
