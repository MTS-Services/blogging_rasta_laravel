<main>
    <section>
        <div class="glass-card rounded-2xl p-6 mb-8">
            <div class="flex items-center justify-center">
                <h3 class="text-2xl font-bold text-text-primary">{{__('Admin Dashboard')}}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6"
            x-transition:enter="transition-all duration-500" x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0">

            {{-- Card 1: Users --}}
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0s;"
                @click="showDetails('users')">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="users" class="w-6 h-6 text-blue-400" />
                    </div>
                    <div class="text-green-400 text-sm font-medium flex items-center gap-1">
                        <flux:icon name="arrow-trending-up" class="w-3 h-3" />
                        +12%
                    </div>
                </div>
                {{-- Adjusted for light/dark mode text --}}
                <h3 class="text-2xl font-bold text-text-primary mb-1" x-text="stats.users.toLocaleString()">
                    12,384</h3>
                {{-- Adjusted for light/dark mode text --}}
                <p class="text-text-secondary text-sm">{{__('Total Users')}}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-400 to-blue-600 rounded-full progress-bar"
                        style="width: 75%;"></div>
                </div>
            </div>

            {{-- Card 2: Revenue --}}
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.2s;"
                @click="showDetails('revenue')">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="banknotes" class="w-6 h-6 text-green-400" />
                    </div>
                    <div class="text-green-400 text-sm font-medium flex items-center gap-1">
                        <flux:icon name="arrow-trending-up" class="w-3 h-3" />
                        +23%
                    </div>
                </div>
                {{-- Adjusted for light/dark mode text --}}
                <h3 class="text-2xl font-bold text-text-primary mb-1">$<span
                        x-text="stats.revenue.toLocaleString()">48,392</span></h3>
                {{-- Adjusted for light/dark mode text --}}
                <p class="text-text-secondary text-sm">{{__('Total Revenue')}}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-400 to-green-600 rounded-full progress-bar"
                        style="width: 60%;"></div>
                </div>
            </div>

            {{-- Card 3: Orders --}}
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.4s;"
                @click="showDetails('orders')">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="shopping-bag" class="w-6 h-6 text-purple-400" />
                    </div>
                    <div class="text-red-400 text-sm font-medium flex items-center gap-1">
                        <flux:icon name="arrow-trending-down" class="w-3 h-3" />
                        -5%
                    </div>
                </div>
                {{-- Adjusted for light/dark mode text --}}
                <h3 class="text-2xl font-bold text-text-primary mb-1" x-text="stats.orders.toLocaleString()">
                    2,847</h3>
                {{-- Adjusted for light/dark mode text --}}
                <p class="text-text-secondary text-sm">{{__('Total Orders')}}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-400 to-purple-600 rounded-full progress-bar"
                        style="width: 45%;"></div>
                </div>
            </div>

            {{-- Card 4: Active Users --}}
            <div class="glass-card rounded-2xl p-6 card-hover float" style="animation-delay: 0.6s;"
                @click="showDetails('active')">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="activity" class="w-6 h-6 text-yellow-400" />
                    </div>
                    <div class="text-yellow-400 text-sm font-medium flex items-center gap-1">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                        {{ __('Live') }}
                    </div>
                </div>
                {{-- Adjusted for light/dark mode text --}}
                <h3 class="text-2xl font-bold text-text-primary mb-1" x-text="stats.activeUsers.toLocaleString()">847
                </h3>
                {{-- Adjusted for light/dark mode text --}}
                <p class="text-text-secondary text-sm">{{__('Active Users')}}</p>
                <div class="mt-4 h-1 bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full pulse-slow progress-bar"
                        style="width: 85%;"></div>
                </div>
            </div>
        </div>

      <!--  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-5"
            x-transition:enter="transition-all duration-500 delay-200"
            x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">

            <div class="lg:col-span-2 glass-card rounded-2xl p-6 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        {{-- Adjusted for light/dark mode text --}}
                        <h3 class="text-xl font-bold text-text-primary mb-1">Revenue Analytics</h3>
                        <p class="text-text-secondary text-sm">Monthly revenue breakdown</p>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- Adjusted for light/dark mode background, text, and border --}}
                        <select
                            class="bg-zinc-100 dark:bg-zinc-800 text-text-primary text-sm px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 outline-none">
                            <option value="monthly">Monthly</option>
                            <option value="weekly">Weekly</option>
                            <option value="daily">Daily</option>
                        </select>
                        {{-- Adjusted for light/dark mode background, text, and border --}}
                        <button
                            class="bg-accent/10 hover:bg-accent/20 text-accent text-sm px-4 py-2 rounded-xl flex items-center gap-2 border border-accent/20 transition-all">
                            <flux:icon name="arrow-down-tray" class="w-4 h-4" />
                            Export
                        </button>
                    </div>
                </div>
                <div class="h-64 relative">
                    <canvas id="revenueChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="space-y-6">
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        {{-- Adjusted for light/dark mode text --}}
                        <h3 class="text-lg font-bold text-text-primary">Recent Activity</h3>
                        {{-- Adjusted for light/dark mode text --}}
                        <button class="text-text-secondary hover:text-text-primary transition-colors">
                            <flux:icon name="move-horizontal" class="w-5 h-5" />
                        </button>
                    </div>
                    <div class="space-y-4">
                        <template x-for="activity in recentActivity" :key="activity.id">
                            {{-- Adjusted for light/dark mode hover state --}}
                            <div
                                class="flex items-center gap-3 p-3 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    :class="activity.iconBg">
                                    <flux:icon name="activity" class="w-4 h-4" x-bind:class="activity.iconColor" />
                                </div>
                                <div class="flex-1">
                                    {{-- Adjusted for light/dark mode text --}}
                                    <p class="text-text-primary text-sm font-medium" x-text="activity.title"></p>
                                    <p class="text-text-secondary text-xs" x-text="activity.time"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    {{-- Adjusted for light/dark mode text --}}
                    <h3 class="text-lg font-bold text-text-primary mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-3">
                        {{-- Adjusted for light/dark mode button styles --}}
                        <button
                            class="bg-accent/10 hover:bg-accent/20 text-accent text-sm font-medium flex items-center justify-center gap-2 p-3 rounded-xl border border-accent/20 hover:scale-105 transition-all">
                            <flux:icon name="user-plus" class="w-4 h-4" />
                            Add User
                        </button>
                        {{-- Adjusted for light/dark mode button styles --}}
                        <button
                            class="bg-zinc-100/50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 p-3 rounded-xl text-text-primary text-sm font-medium flex items-center justify-center gap-2 border border-zinc-200 dark:border-zinc-700 hover:scale-105 transition-all">
                            <flux:icon name="envelope" class="w-4 h-4" />
                            Send Mail
                        </button>
                        {{-- Adjusted for light/dark mode button styles --}}
                        <button
                            class="bg-zinc-100/50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 p-3 rounded-xl text-text-primary text-sm font-medium flex items-center justify-center gap-2 border border-zinc-200 dark:border-zinc-700 hover:scale-105 transition-all">
                            <flux:icon name="file-text" class="w-4 h-4" />
                            Reports
                        </button>
                        {{-- Adjusted for light/dark mode button styles --}}
                        <button
                            class="bg-zinc-100/50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 p-3 rounded-xl text-text-primary text-sm font-medium flex items-center justify-center gap-2 border border-zinc-200 dark:border-zinc-700 hover:scale-105 transition-all">
                            <flux:icon name="cog-8-tooth" class="w-4 h-4" />
                            Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    -->
    </section>

</main>
