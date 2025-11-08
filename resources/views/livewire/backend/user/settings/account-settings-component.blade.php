<section class="min-h-screen bg-bg-secondary py-8">
    <section class=" mx-auto px-4">
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-text-primary">{{ __('Account Settings') }}</h1>
            <x-ui.button href="{{ route('user.purchased-orders') }}" class="w-fit! sm:w-auto! py-2!">
                {{ __('Seller API') }}
            </x-ui.button>
        </div>

        <div class=" mx-auto space-y-6">
            {{-- Profile Section --}}
            <section class="sm:bg-bg-primary rounded-2xl sm:p-15 md:20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-primary mb-8">{{ __('Profile') }}</h2>

                {{-- Profile Image --}}
                <div class="flex items-start bg-zinc-50/10 rounded-lg gap-6 p-5 mb-6">
                    <div class="relative">
                        <img src="{{ auth()->user()->avatar ?? asset('assets/images/user_profile/Ellipse 474.png') }}"
                            alt="Profile" class="w-20 h-20 rounded-full object-cover ring-2 ring-accent/20">

                    </div>
                    <div class="flex-col">
                        <x-ui.button href="" class="w-fit! py-2!">
                            {{ __('Upload image') }}
                        </x-ui.button>
                        <div class="">
                            <span
                                class="text-base text-text-white mt-2">{{ __('Allowed file types: png, jpg, jpeg') }}</span>
                        </div>

                    </div>
                </div>

                {{-- Bio Textarea --}}
                <div class="p-6 bg-zinc-50/10 rounded-lg" x-data="{ editMode: false }">
                    <div class="flex justify-between items-center gap-6 mb-3">
                        <h2 class="block text-base font-medium text-text-primary">{{ __('Your description') }}</h2>
                        <div class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 justify-end rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition"
                            @click="editMode = true">
                            <x-phosphor name="note-pencil" variant="regular" />
                        </div>
                    </div>


                    <!-- Display Mode -->
                    <div class="" x-show="!editMode">
                        <div class="w-full p-3 bg-zinc-50/20 rounded-lg">
                            <p class="text-text-white text-xs">{{ __('Hey there!') }}</p>
                            <p class="text-text-white text-xs">
                                {{ __('At PixelStoreLAT, we bring you the best digital deals, game keys, and in-game items — fast, safe, and hassle-free. Trusted by thousands of gamers worldwide with 97% positive reviews. Level up your experience with us today!') }}
                            </p>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <div x-show="editMode" x-cloak>
                        <div class="relative">
                            <textarea rows="4"
                                class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-3 text-text-primary placeholder:text-text-muted focus:outline-hidden focus:ring-2 focus:ring-accent resize-none"
                                placeholder="Write a short bio about yourself...">{{ old('bio', 'I am a marketing expert with passion to serve you with impactful content') }}</textarea>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex justify-start gap-3 mt-6">
                            <x-ui.button href="" @click="editMode = false" class="w-fit! py-2!">
                                {{ __('Upload image') }}
                            </x-ui.button>
                            <button type="button" @click="editMode = false"
                                class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>




            </section>

            {{-- Profile Details Section --}}
            <section class="sm:bg-bg-primary rounded-2xl  mt-5 sm:p-15 md:20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-white mb-8">{{ __('Profile') }}</h2>

                <form class="space-y-5">
                    {{-- User Name --}}

                    {{-- First Name --}}
                    <div x-data="{ editMode: false }">
                        <div class="p-3 sm:p-6 bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('First name:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full p-3 bg-zinc-50/20 rounded-lg">
                                    <p class="text-text-white text-xs">{{ __('luisa') }}</p>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('User name:') }}</label>
                            <div class="relative">
                                <input type="text" name="username"
                                    value="{{ old('username', auth()->user()->username ?? '') }}"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="Enter username">
                                <button type="button"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button href="" @click="editMode = false" class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Last name --}}
                    <div x-data="{ editMode: false }">
                        <div class="p-3 sm:p-6 bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Last name:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full p-3 bg-zinc-50/20 rounded-lg">
                                    <p class="text-text-white text-xs">{{ __('Cuna') }}</p>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('Last name:') }}</label>
                            <div class="relative">
                                <input type="text" name="company" value="Cuna"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="Enter company name">
                                <button type="button"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button href="" @click="editMode = false" class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div x-data="{ editMode: false }">
                        <div class="p-3 sm:p-6 bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Email:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full">
                                    <div class="p-3 bg-zinc-50/20 rounded-lg">
                                        <p class="text-text-white text-xs">{{ __('luisacuna2254@gmail.com') }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-text-white text-sm sm:text-xl"><span
                                                class="text-pink-500">{{ __('Verified') }}</span>
                                            {{ __('This email is linked to your account. It is not visible to other users.') }}
                                        </p>
                                    </div>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('Email:') }}</label>
                            <div class="relative">
                                <input type="email" name="email" value="luisacuna2254@gmail.com"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="Enter email">
                                <span
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-xs text-text-muted bg-bg-primary px-2 py-1 rounded">
                                    {{ __('This field is linked and can only be filled in once for user') }}
                                </span>
                            </div>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button href="" @click="editMode = false" class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Username --}}
                    <div x-data="{ editMode: false }">
                        <div class="p-3 sm:p-6 bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Username:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full">
                                    <div class="p-3 bg-zinc-50/20 rounded-lg">
                                        <p class="text-text-white text-xs">{{ __('PixelStoreLAT') }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-text-white text-sm sm:text-xl">
                                            {{ __('Name that is visible to other "Porkbun" users. You can change your username once every 90 days.') }}
                                        </p>
                                    </div>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('Username:') }}</label>
                            <div class="relative">
                                <input type="text" name="Username" value="PixelStoreLAT"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="Enter location">
                                <button type="button"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button href="" @click="editMode = false" class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div x-data="{ editMode: false }">
                        <div class="p-3 sm:p-6 bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Password:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full">
                                    <div class="p-3 bg-zinc-50/20 rounded-lg">
                                        <p class="text-text-white text-xs">{{ __('********') }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-text-white text-sm sm:text-xl">
                                            {{ __('Password can only be changed if you are using the email/password login flow') }}
                                        </p>
                                    </div>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('Password') }}</label>
                            <div class="relative">
                                <input type="url" name="url" value="********"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="https://">
                                <button type="button"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-text-muted mt-1.5">
                                {{ __('You are only e-mails to other. You can type your URL here, and we will redirect them to your personal website or their site') }}
                            </p>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button href="" @click="editMode = false" class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-zinc-200/50 text-text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </section>

            {{-- Email Notifications Section --}}
            <section class="sm:bg-bg-primary rounded-2xl sm:p-15 md:20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-white mb-6">{{ __('Email notifications') }}
                </h2>

                <div class="space-y-4">
                    @php
                        $notifications = [
                            [
                                'key' => 'manage_notification',
                                'label' => 'Manage notification',
                                'sub_title' => 'When you receive a new order.',
                            ],
                            [
                                'key' => 'new_update',
                                'label' => 'New update',
                                'sub_title' => 'When you receive a new message',
                            ],
                            [
                                'key' => 'new_request',
                                'label' => 'New request',
                                'sub_title' => 'When your order status changes',
                            ],
                            [
                                'key' => 'message_received',
                                'label' => 'Message received',
                                'sub_title' => 'When your dispute is resolved or updated',
                            ],
                            [
                                'key' => 'status_changed',
                                'label' => 'Status changed',
                                'sub_title' => 'When your payment is received or refunded',
                            ],
                            [
                                'key' => 'request_rejected',
                                'label' => 'Request rejected',
                                'sub_title' => 'When you request a withdrawal, and when it is processed',
                            ],
                            [
                                'key' => 'dispute_created',
                                'label' => 'Dispute created',
                                'sub_title' => 'When your verification is processed or updated',
                            ],
                            [
                                'key' => 'payment_received',
                                'label' => 'Payment received',
                                'sub_title' => 'When you receive boosting offers or updates',
                            ],
                        ];
                    @endphp

                    @foreach ($notifications as $notification)
                        <div
                            class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
                            <label class="text-xl text-text-white cursor-pointer flex-1">
                                {{ $notification['label'] }}
                                <span
                                    class="text-sm text-text-muted justify-start block">{{ $notification['sub_title'] }}</span>
                            </label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notifications[{{ $notification['key'] }}]"
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
        </s>
    </section>
