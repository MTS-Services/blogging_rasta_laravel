<div>
    {{-- Page Header --}}

    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Blog Details') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.blog.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">

                <div class="grid lg:grid-cols-3 gap-6">

                    {{-- Left Column --}}
                    <div class="flex flex-col h-auto p-4   ">
                        <h2 class="text-xl text-text-primary font-semibold mb-6">{{ __('Profile Image') }}</h2>
                        <div class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-pink-100 overflow-hidden">
                            <img src="{{ storage_url($data->file) }}" alt="Profile Image"
                                class="w-full h-full object-cover">
                        </div>

                    </div>
                </div>
                <div class="glass-card shadow-glass-card rounded-xl p-6 min-h-[500px]">
                    <!-- Product Data Section -->
                    <div class="px-8 py-8">
                        <div class="mb-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Title') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->title }}</p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Slug') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->slug }}</p>
                                </div>
                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Status') }}
                                    </p>
                                    <p
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft {{ $data->status->color() }}">
                                        {{ $data->status->label() }}
                                    </p>
                                </div>
                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Meta Title') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->meta_title }}</p>
                                </div>
                                <div
                                    class="bg-slate-50 col-span-4 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Meta Keywords') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ is_array($data->meta_keywords) ? implode(', ', $data->meta_keywords) : $data->meta_keywords ?? 'N/A' }}
                                    </p>

                                </div>
                                <div
                                    class="bg-slate-50 col-span-4 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Meta Description') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">{!! $data->meta_description !!}</p>
                                </div>
                                <div
                                    class="bg-slate-50 col-span-4 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Description') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">{!! $data->description !!}</p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Created At') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ $data->created_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Updated At') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ $data->updated_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Deleted At') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ $data->deleted_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Restored At') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ $data->restored_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Created By') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ $data->creater_admin->name ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Updated By') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ $data->updater_admin->name ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Deleted By') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ $data->deleter_admin->name ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-slate-50 dark:bg-gray-700  rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Restored By') }}
                                    </p>
                                    <p class="text-slate-400 text-lg font-bold">
                                        {{ $data->restorer_admin->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
