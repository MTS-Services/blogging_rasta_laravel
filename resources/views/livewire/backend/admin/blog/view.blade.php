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

                    {{-- Left Column - Blog Image --}}
                    <div class="flex flex-col h-auto p-4 lg:p-6">
                        <h2 class="text-xl text-text-primary font-semibold mb-4">{{ __('Blog Image') }}</h2>
                        @if($data->file)
                            <div class="w-full max-w-sm aspect-video rounded-xl overflow-hidden border-2 border-zinc-200 dark:border-zinc-600 bg-zinc-100 dark:bg-zinc-800">
                                <img src="{{ storage_url($data->file) }}" alt="{{ $data->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-full max-w-sm aspect-video rounded-xl border-2 border-dashed border-zinc-300 dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-800/50 flex items-center justify-center">
                                <span class="text-zinc-400 dark:text-zinc-500 text-sm">{{ __('No image') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="glass-card shadow-glass-card rounded-xl p-6 min-h-[500px]">
                    <!-- Product Data Section -->
                    <div class="px-8 py-8">
                        <div class="mb-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Title') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">{{ $data->title }}</p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Slug') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">{{ $data->slug }}</p>
                                </div>
                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">{{ __('Status') }}
                                    </p>
                                    <p
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft {{ $data->status->color() }}">
                                        {{ $data->status->label() }}
                                    </p>
                                </div>
                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Meta Title') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">{{ $data->meta_title }}</p>
                                </div>
                                <div
                                    class="bg-zinc-50 col-span-4 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Meta Keywords') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ is_array($data->meta_keywords) ? implode(', ', $data->meta_keywords) : $data->meta_keywords ?? 'N/A' }}
                                    </p>

                                </div>
                                <div
                                    class="bg-zinc-50 col-span-4 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Meta Description') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">{!! $data->meta_description !!}</p>
                                </div>
                                <div
                                    class="bg-zinc-50 col-span-4 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Description') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">{!! $data->description !!}</p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Created At') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->created_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Updated At') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->updated_at_formatted ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Deleted At') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->deleted_at_formatted ?? 'N/A' }}
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

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Created By') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->creater_admin->name ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Updated By') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->updater_admin->name ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-zinc-50 dark:bg-gray-700 rounded-lg p-4 border border-zinc-200">
                                    <p class="text-text-white text-xs font-semibold mb-2 uppercase">
                                        {{ __('Deleted By') }}
                                    </p>
                                    <p class="text-zinc-800 text-lg font-bold">
                                        {{ $data->deleter_admin->name ?? 'N/A' }}</p>
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

            {{-- Blog Comments Section --}}
            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20 mt-6">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-xl font-bold text-text-primary">{{ __('Blog Comments') }} ({{ $data->comments->count() }})</h2>
                </div>
                <div class="p-6">
                    @if($data->comments->isEmpty())
                        <p class="text-zinc-500 dark:text-zinc-400">{{ __('No comments yet.') }}</p>
                    @else
                        <div class="space-y-4">
                            @foreach($data->comments as $comment)
                                <div class="flex gap-4 p-4 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden bg-second-500/20 border border-second-500/40">
                                        @php
                                            $commenter = $comment->user;
                                            $avatarUrl = $commenter ? $commenter->avatar_url : 'https://ui-avatars.com/api/?name=U';
                                        @endphp
                                        <img src="{{ $avatarUrl }}" alt="{{ $commenter->name ?? 'User' }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-text-primary">{{ $comment->user->name ?? __('User') }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $comment->created_at->format('M j, Y g:i A') }}</p>
                                        <p class="mt-2 text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">{{ $comment->body }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
