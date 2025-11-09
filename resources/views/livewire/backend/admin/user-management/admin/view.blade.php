<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Admin Profile') }}
            </h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.am.admin.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card shadow-glass-card rounded-xl p-6 min-h-[500px]">
        {{-- PERSONAL INFO (Default Tab) --}}

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Left Column --}}
            <div class="flex flex-col h-auto p-4 border-r lg:border-r-2 border-zinc-100">
                <h2 class="text-xl text-text-primary font-semibold mb-6">{{__('Profile Image')}}</h2>

                <div class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-pink-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $data->avatar) }}" alt="Profile Image"
                        class="w-full h-full object-cover">
                </div>

                <div class="flex flex-col items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-center mb-1 text-text-primary">{{ $data->name }}</h3>
                    <p class="text-text-secondary">{{ $data->email }}</p>
                </div>

                <div class="space-y-4 text-sm">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-text-muted">{{__('Phone')}}</p>
                            <p class="font-medium text-text-primary">{{ $admin->phone }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-text-muted">{{__('Email')}}</p>
                            <p class="font-medium text-text-primary">{{ $admin->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002 12c0 2.514.805 4.851 2.152 6.744.912 1.258 2.057 2.378 3.394 3.315C8.922 23.473 10.45 24 12 24c1.55 0 3.078-.527 4.454-1.282 1.337-.937 2.482-2.057 3.394-3.315C21.195 16.851 22 14.514 22 12c0-3.37-1.37-6.495-3.69-8.744l-.382-.36z">
                            </path>
                        </svg>
                        <div>
                            <p class="text-text-muted">{{__('Account Status')}}</p>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold inline-block
                                    @if ($admin->status_label === 'Active') bg-zinc-100 text-zinc-700 @else bg-pink-100 text-pink-700 @endif">
                                {{ $admin->status_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-span-1 lg:col-span-2 p-4">
                <h2 class="text-xl font-semibold mb-6 border-b border-zinc-100 pb-2 text-text-primary">{{__('Profile Information')}}</h2>

                <div class="grid md:grid-cols-2 gap-8 text-base">
                    {{-- Name --}}
                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">{{__('Name')}}</p>
                        <h3 class="text-lg font-medium text-text-primary">{{ $admin->name }}</h3>
                    </div>

                    {{-- Email --}}
                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">{{__('Email')}}</p>
                        <h3 class="text-lg font-medium text-text-primary">{{ $admin->email }}</h3>
                    </div>

                    {{-- phone --}}
                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">{{__('Phone')}}</p>
                        <h3 class="text-lg font-medium text-text-primary">{{ $admin->phone }}</h3>
                    </div>

                    {{-- Status --}}
                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">{{__('Status')}}</p>
                        {{-- <h3 class="text-lg font-medium text-text-primary">{{ $admin->date_of_birth }}</h3> --}}
                        <h3
                            class="px-3 py-1 rounded-full text-xs font-bold inline-block
                                    @if ($admin->status_label === 'Active') bg-zinc-100 text-zinc-700 @else bg-pink-100 text-pink-700 @endif">
                            {{ $admin->status_label }}
                        </h3>
                    </div>

                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">Email Verified At</p>
                        <h3 class="text-lg font-medium text-text-primary">
                            {{ $data->email_verified_at ? $data->email_verified_at->format('Y-m-d H:i:s') : 'Not Verified' }}
                        </h3>
                    </div>

                    {{-- <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">Phone Verified At</p>
                        <h3 class="text-lg font-medium text-text-primary">
                            {{ $data->phone_verified_at ? $data->phone_verified_at->format('Y-m-d H:i:s') : 'Not Verified' }}
                        </h3>
                    </div> --}}

                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">Two Factor Enabled</p>
                        <h3 class="text-lg font-medium text-text-primary">
                            {{ $data->two_factor_enabled ? 'Yes' : 'No' }}
                        </h3>
                    </div>

                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">Last Login At</p>
                        <h3 class="text-lg font-medium text-text-primary">
                            {{ $data->last_login_at ? $data->last_login_at->format('Y-m-d H:i:s') : 'Never Logged In' }}
                        </h3>
                    </div>

                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">Last Login IP</p>
                        <h3 class="text-lg font-medium text-text-primary">{{ $data->last_login_ip ?? 'N/A' }}</h3>
                    </div>

                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">Created At</p>
                        <h3 class="text-lg font-medium text-text-primary">
                            {{ $data->created_at->format('Y-m-d H:i:s') }}</h3>
                    </div>

                    <div>
                        <p class="text-text-muted mb-1 text-sm uppercase tracking-wider">Updated At</p>
                        <h3 class="text-lg font-medium text-text-primary">
                            {{ $data->updated_at->format('Y-m-d H:i:s') }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
