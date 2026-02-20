<div>
    <div class="bg-bg-secondary w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Blog Category Details') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.blog-category.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20">
                <div class="glass-card shadow-glass-card rounded-xl p-6 min-h-[500px]">
                    <div class="px-8 py-8">
                        <div class="mb-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Title') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->title }}</p>
                                </div>
                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Slug') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->slug }}</p>
                                </div>
                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Status') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->status }}</p>
                                </div>
                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Created At') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->created_at_formatted ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Updated At') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->updated_at_formatted ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Created By') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->creater_admin->name ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-slate-50 dark:bg-gray-700 rounded-lg p-4 border border-slate-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Updated By') }}</p>
                                    <p class="text-slate-400 text-lg font-bold">{{ $data->updater_admin->name ?? 'N/A' }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
