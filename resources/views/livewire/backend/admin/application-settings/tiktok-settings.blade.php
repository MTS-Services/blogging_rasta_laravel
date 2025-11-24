<section>
    {{-- Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-white">{{ __('TikTok Settings') }}</h2>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit.prevent="updateSettings">

            <!-- MAIN GRID -->
            <div class="grid grid-cols-1 gap-5">

                <!-- RapidAPI Key -->
                <div>
                    <x-ui.label value="{{ __('RapidAPI Key') }}" />
                    <x-ui.input type="text" placeholder="{{ __('Enter your RapidAPI key') }}"
                        wire:model.defer="form.rapidapi_key" />
                    <x-ui.input-error :messages="$errors->get('form.rapidapi_key')" />
                    <p class="text-xs text-gray-400 mt-1">{{ __('Get your API key from RapidAPI TikTok API') }}</p>
                </div>

                <!-- Featured Users Section -->
                <div class="pt-5 mt-3 ">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-white">{{ __('Featured TikTok Users') }}</h3>
                        <x-ui.button type="button" variant="secondary" wire:click="addFeaturedUser"
                            class="w-auto! py-2!">
                            <flux:icon name="plus" class="w-4 h-4" />
                            {{ __('Add User') }}
                        </x-ui.button>
                    </div>

                    <div class="space-y-4">
                        @forelse($form->featured_users as $index => $user)
                            <div wire:key="featured-user-{{ $index }}-{{ $loop->iteration }}" class="">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                                    <!-- Username -->
                                    <div>
                                        <x-ui.label value="{{ __('Username') }}" />
                                        <x-ui.input type="text" placeholder="{{ __('e.g., diodioglowskin') }}"
                                            wire:model.defer="form.featured_users.{{ $index }}.username" />
                                        <x-ui.input-error :messages="$errors->get('form.featured_users.' . $index . '.username')" />
                                    </div>

                                    <!-- Display Name -->
                                    <div>
                                        <x-ui.label value="{{ __('Display Name') }}" />
                                        <x-ui.input type="text" placeholder="{{ __('e.g., Diodio Glow Skin') }}"
                                            wire:model.defer="form.featured_users.{{ $index }}.display_name" />
                                        <x-ui.input-error :messages="$errors->get('form.featured_users.' . $index . '.display_name')" />
                                    </div>

                                    <!-- Max Videos -->
                                    <div class="flex items-end gap-2">
                                        <div class="flex-1">
                                            <x-ui.label value="{{ __('Max Videos') }}" />
                                            <x-ui.input type="number" min="1"
                                                wire:model.defer="form.featured_users.{{ $index }}.max_videos" />
                                            <x-ui.input-error :messages="$errors->get('form.featured_users.' . $index . '.max_videos')" />
                                        </div>

                                        @if (count($form->featured_users) > 1)
                                            <button type="button" wire:click="removeFeaturedUser({{ $index }})"
                                                class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 flex items-center justify-center"
                                                wire:confirm="Are you sure you want to remove this user?">
                                                <flux:icon name="trash" class="w-4 h-4" />
                                            </button>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400">
                                <p>{{ __('No featured users added yet.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Video Settings -->
                <div class="pt-5 mt-3 ">
                    <h3 class="text-lg font-semibold text-text-white mb-4">{{ __('Video Display Settings') }}</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <!-- Default Max Videos Per User -->
                        <div>
                            <x-ui.label value="{{ __('Default Max Videos Per User') }}" />
                            <x-ui.input type="number" min="1"
                                wire:model.defer="form.default_max_videos_per_user" />
                            <x-ui.input-error :messages="$errors->get('form.default_max_videos_per_user')" />
                            <p class="text-xs text-gray-400 mt-1">{{ __('Default videos to fetch per user') }}</p>
                        </div>

                        <!-- Videos Per Page -->
                        <div>
                            <x-ui.label value="{{ __('Videos Per Page') }}" />
                            <x-ui.input type="number" min="1" wire:model.defer="form.videos_per_page" />
                            <x-ui.input-error :messages="$errors->get('form.videos_per_page')" />
                            <p class="text-xs text-gray-400 mt-1">{{ __('Total videos to display per page') }}</p>
                        </div>

                        <!-- Videos Per User Per Page -->
                        <div>
                            <x-ui.label value="{{ __('Videos Per User Per Page') }}" />
                            <x-ui.input type="number" min="1"
                                wire:model.defer="form.videos_per_user_per_page" />
                            <x-ui.input-error :messages="$errors->get('form.videos_per_user_per_page')" />
                            <p class="text-xs text-gray-400 mt-1">{{ __('Videos per user to show on each page') }}</p>
                        </div>

                        <!-- Cache Duration -->
                        {{-- <div>
                            <x-ui.label value="{{ __('Cache Duration (seconds)') }}" />
                            <x-ui.input
                                type="number"
                                min="60"
                                wire:model.defer="form.cache_duration"
                            />
                            <x-ui.input-error :messages="$errors->get('form.cache_duration')" />
                            <p class="text-xs text-gray-400 mt-1">{{ __('How long to cache video data (60-86400)') }}</p>
                        </div> --}}

                    </div>
                </div>

            </div>
            <!-- END MAIN GRID -->

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-4 mt-6 pt-6 ">
                <x-ui.button type="reset" variant="tertiary" class="w-auto! py-2!" wire:click="mount">
                    <flux:icon name="x-circle" class="w-4 h-4" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="submit" class="w-auto! py-2!" wire:loading.attr="disabled"
                    wire:target="updateSettings">
                    <flux:icon name="check-circle" class="w-4 h-4" />
                    <span wire:loading.remove wire:target="updateSettings">{{ __('Save Settings') }}</span>
                    <span wire:loading wire:target="updateSettings">{{ __('Saving...') }}</span>
                </x-ui.button>
            </div>

        </form>
    </div>

</section>
