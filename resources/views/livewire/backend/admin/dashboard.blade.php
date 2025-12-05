<main>
    <section>
        <div class="glass-card rounded-2xl p-6 mb-8">
            <div class="flex items-center justify-center">
                <h3 class="text-2xl font-bold text-text-primary">{{ __('Admin Dashboard') }}</h3>
                <a href="{{ route('admin.sitemap.generate') }}" class="btn btn-primary">Generate New Sitemap</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">

            <!-- Total TikTok Users -->
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.4s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-cyan-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="user-group" class="w-6 h-6 text-cyan-400" />
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-text-primary mb-1">
                    {{ number_format($stats['total_tiktok_users']) }}
                </h3>
                <p class="text-text-secondary text-sm">{{ __('TikTok Users') }}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-cyan-400 to-cyan-600 rounded-full progress-bar"
                        style="width: 100%;"></div>
                </div>
            </div>

            <!-- Total Videos -->
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.4s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-pink-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="video-camera" class="w-6 h-6 text-pink-400" />
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-text-primary mb-1">
                    {{ number_format($stats['total_videos']) }}
                </h3>
                <p class="text-text-secondary text-sm">{{ __('Total Videos') }}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-pink-400 to-pink-600 rounded-full progress-bar"
                        style="width: 100%;"></div>
                </div>
            </div>

            <!-- Active Videos -->
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.6s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-teal-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="play-circle" class="w-6 h-6 text-teal-400" />
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-text-primary mb-1">
                    {{ number_format($stats['active_videos']) }}
                </h3>
                <p class="text-text-secondary text-sm">{{ __('Active Videos') }}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-teal-400 to-teal-600 rounded-full progress-bar"
                        style="width: 100%;"></div>
                </div>
            </div>

            <!-- Inactive Videos -->
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="pause-circle" class="w-6 h-6 text-gray-400" />
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-text-primary mb-1">
                    {{ number_format($stats['inactive_videos']) }}
                </h3>
                <p class="text-text-secondary text-sm">{{ __('Inactive Videos') }}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-gray-400 to-gray-600 rounded-full progress-bar"
                        style="width: 100%;"></div>
                </div>
            </div>

            <!-- Featured Videos -->
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="star" class="w-6 h-6 text-amber-400" />
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-text-primary mb-1">
                    {{ number_format($stats['featured_videos']) }}
                </h3>
                <p class="text-text-secondary text-sm">{{ __('Featured Videos') }}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-400 to-amber-600 rounded-full progress-bar"
                        style="width: 100%;"></div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.6s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="shopping-bag" class="w-6 h-6 text-purple-400" />
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-text-primary mb-1">
                    {{ number_format($stats['total_products']) }}
                </h3>
                <p class="text-text-secondary text-sm">{{ __('Total Products') }}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-400 to-purple-600 rounded-full progress-bar"
                        style="width: 100%;"></div>
                </div>
            </div>

            <!-- Active Products -->
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="check-badge" class="w-6 h-6 text-yellow-400" />
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-text-primary mb-1">
                    {{ number_format($stats['active_products']) }}
                </h3>
                <p class="text-text-secondary text-sm">{{ __('Active Products') }}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full progress-bar"
                        style="width: 100%;"></div>
                </div>
            </div>

            <!-- Inactive Products -->
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="archive-box" class="w-6 h-6 text-orange-400" />
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-text-primary mb-1">
                    {{ number_format($stats['inactive_products']) }}
                </h3>
                <p class="text-text-secondary text-sm">{{ __('Inactive Products') }}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-orange-400 to-orange-600 rounded-full progress-bar"
                        style="width: 100%;"></div>
                </div>
            </div>

        </div>


        <!-- TikTok Users Details Table -->
        @if (count($tiktokUsers) > 0)
            <div class="glass-card rounded-2xl p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-text-primary">{{ __('TikTok Users Videos Status') }}</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="text-left py-3 px-4 text-text-secondary text-sm font-medium">
                                    {{ __('Username') }}</th>
                                <th class="text-center py-3 px-4 text-text-secondary text-sm font-medium">
                                    {{ __('Total Videos') }}</th>
                                <th class="text-center py-3 px-4 text-text-secondary text-sm font-medium">
                                    {{ __('Active Videos') }}</th>
                                <th class="text-center py-3 px-4 text-text-secondary text-sm font-medium">
                                    {{ __('Featured Videos') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tiktokUsers as $user)
                                <tr
                                    class="border-b border-zinc-100 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($user['username'], 0, 1)) }}
                                            </div>
                                            <span
                                                class="text-text-primary font-medium">{{ '@' . $user['username'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-blue-500/10 text-blue-600 dark:text-blue-400 text-sm font-medium">
                                            {{ number_format($user['total_videos']) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-green-500/10 text-green-600 dark:text-green-400 text-sm font-medium">
                                            {{ number_format($user['active_videos']) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-medium">
                                            {{ number_format($user['featured_videos']) }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </section>
</main>
