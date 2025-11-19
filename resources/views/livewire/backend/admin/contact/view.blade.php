<div>
    {{-- Page Header --}}

    <div class="b w-full rounded">
        <div class="mx-auto">
            <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                        {{ __('Contact Details') }}
                    </h2>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <x-ui.button href="{{ route('admin.contact.index') }}" class="w-auto py-2!">
                            <flux:icon name="arrow-left"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                            {{ __('Back') }}
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <!-- Main Card -->
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden ">
                <div class="glass-card shadow-glass-card rounded-xl p-6 min-h-[500px]">
                    <!-- Product Data Section -->
                    <div class="px-8 py-8">
                        <div class="mb-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Name') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">{{ $data->name }}</p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Email') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">{{ $data->email }}</p>
                                </div>
                                
                                <div
                                    class="bg-zinc-50 col-span-2 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Message') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">{{ $data->message }}</p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Sent At') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->created_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Restored At') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->restored_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="bg-zinc-50 dark:bg-gray-700  rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Restored By') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->restorer_admin->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
