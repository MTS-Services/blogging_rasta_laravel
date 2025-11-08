<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Language Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.as.language.edit', $language) }}" type="secondary" class="flex-1 sm:flex-none">
                    <flux:icon name="pencil" class="w-4 h-4" />
                    <span class="sm:inline">{{ __('Edit') }}</span>
                </x-ui.button>

                <x-ui.button href="{{ route('admin.as.language.index') }}" class="flex-1 sm:flex-none">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    <span class="sm:inline text-white">{{ __('Back') }}</span>
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 min-h-[500px]">
        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Left Column --}}
            <div class="flex flex-col h-auto p-4 border-r lg:border-r-2 border-gray-100 dark:border-gray-700">
                <h2 class="text-xl text-gray-800 dark:text-gray-200 font-semibold mb-6">{{__('Language Flag')}}</h2>

                <div class="w-32 h-24 rounded-lg mx-auto mb-6 border-4 border-blue-100 dark:border-blue-900 overflow-hidden bg-gray-50 dark:bg-gray-700 flex items-center justify-center">
                    @if($language->flag_icon)
                        <img src="{{ $language->flag_icon }}" alt="{{ $language->name }} flag"
                            class="w-full h-full object-cover">
                    @else
                        <div class="text-gray-400 dark:text-gray-500 text-center">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                            </svg>
                            <p class="text-xs">{{__('No Flag')}}</p>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-center mb-1 text-gray-900 dark:text-white">{{ $language->name }}</h3>
                    @if($language->native_name)
                        <p class="text-gray-600 dark:text-gray-400 text-lg">{{ $language->native_name }}</p>
                    @endif
                </div>

                <div class="space-y-4 text-sm">
                    {{-- Locale --}}
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">{{__('Locale')}}</p>
                            <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $language->locale }}</p>
                        </div>
                    </div>

                    {{-- Country Code --}}
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">{{__('Country Code')}}</p>
                            <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $language->country_code }}</p>
                        </div>
                    </div>

                    {{-- Direction --}}
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                        </svg>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">{{__('Text Direction')}}</p>
                            <div class="flex items-center gap-2">
                                <span class="text-xl">{{ $language->direction->value === 'ltr' ? '→' : '←' }}</span>
                                <p class="font-semibold text-gray-900 dark:text-white uppercase">{{ $language->direction->value }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">{{__('Status')}}</p>
                            <span class="px-3 py-1 rounded-full text-xs font-bold inline-block
                                @if ($language->status->value === '1')
                                    bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200
                                @else
                                    bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200
                                @endif">
                                {{ $language->status->label() }}
                            </span>
                        </div>
                    </div>

                    {{-- Is Default --}}
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">{{__('Default Language')}}</p>
                            <span class="px-3 py-1 rounded-full text-xs font-bold inline-block
                                @if ($language->is_default)
                                    bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200
                                @else
                                    bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                {{ $language->is_default ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-span-1 lg:col-span-2 p-4">
                <h2 class="text-xl font-semibold mb-6 border-b pb-2 text-gray-800 dark:text-gray-200">{{__('Language Information')}}</h2>

                <div class="grid md:grid-cols-2 gap-8 text-base">
                    {{-- Name --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Language Name')}}</p>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $language->name }}</h3>
                    </div>

                    {{-- Native Name --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Native Name')}}</p>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $language->native_name ?? 'N/A' }}
                        </h3>
                    </div>

                    {{-- Locale --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Locale Code')}}</p>
                        <h3 class="text-lg font-mono font-medium text-gray-900 dark:text-white uppercase">{{ $language->locale }}</h3>
                    </div>

                    {{-- Country Code --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Country Code')}}</p>
                        <h3 class="text-lg font-mono font-medium text-gray-900 dark:text-white uppercase">{{ $language->country_code }}</h3>
                    </div>

                    {{-- Direction --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Text Direction')}}</p>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">{{ $language->direction->value === 'ltr' ? '→' : '←' }}</span>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $language->direction->label() }}
                            </h3>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Status')}}</p>
                        <h3 class="px-3 py-1 rounded-full text-xs font-bold inline-block
                            @if ($language->status->value === '1')
                                bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200
                            @else
                                bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200
                            @endif">
                            {{ $language->status->label() }}
                        </h3>
                    </div>

                    {{-- Default Language --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Default Language')}}</p>
                        <h3 class="px-3 py-1 rounded-full text-xs font-bold inline-block
                            @if ($language->is_default)
                                bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200
                            @else
                                bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                            @endif">
                            {{ $language->is_default ? 'Yes' : 'No' }}
                        </h3>
                    </div>

                    {{-- Created At --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Created At')}}</p>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $language->created_at->format('M d, Y') }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $language->created_at->format('h:i A') }}</p>
                    </div>

                    {{-- Updated At --}}
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Last Updated')}}</p>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $language->updated_at->format('M d, Y') }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $language->updated_at->format('h:i A') }}</p>
                    </div>

                    {{-- Created By --}}
                    @if($language->creater_admin)
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Created By')}}</p>
                        <div class="flex items-center gap-2">
                            @if($language->creater_admin->avatar)
                                <img src="{{ asset('storage/' . $language->creater_admin->avatar) }}"
                                     alt="{{ $language->creater_admin->name }}"
                                     class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                            @endif
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $language->creater_admin->name }}
                            </h3>
                        </div>
                    </div>
                    @endif

                    {{-- Updated By --}}
                    @if($language->updater_admin)
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 mb-1 text-sm uppercase tracking-wider">{{__('Updated By')}}</p>
                        <div class="flex items-center gap-2">
                            @if($language->updater_admin->avatar)
                                <img src="{{ asset('storage/' . $language->updater_admin->avatar) }}"
                                     alt="{{ $language->updater_admin->name }}"
                                     class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                            @endif
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $language->updater_admin->name }}
                            </h3>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Additional Info Section --}}
                @if($language->flag_icon)
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">{{__('Flag Preview')}}</h3>
                    <div class="flex items-center gap-4">
                        <img src="{{ $language->flag_icon }}"
                             alt="{{ $language->name }} flag"
                             class="w-24 h-16 rounded-lg object-cover border-2 border-gray-200 dark:border-gray-600 shadow-sm">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{__('Flag URL:')}}</p>
                            <a href="{{ $language->flag_icon }}"
                               target="_blank"
                               class="text-sm text-blue-600 dark:text-blue-400 hover:underline break-all">
                                {{ $language->flag_icon }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
