<section>
    {{-- Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-white">{{ __('General Settings') }}</h2>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="updateSettings">

            <!-- SINGLE MAIN GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                      <!-- Row 1: Logo + Favicon -->
                <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <!-- App Logo -->
                    <div>
                        <x-ui.file-input wire:model="form.app_logo" id="app_logo" label="{{ __('App Logo') }}"
                            hint="{{ __('Max: 400x400') }}" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg"
                            :error="$errors->first('form.app_logo')" />
                        
                        {{-- Current App Logo Preview --}}
                        @if(!empty($general_settings['app_logo']) && !$form->app_logo)
                            <div class="mt-3">
                                <p class="text-sm text-gray-400 mb-2">{{ __('Current Logo:') }}</p>
                                <img src="{{ asset('storage/' . $general_settings['app_logo']) }}" 
                                     alt="App Logo" 
                                     class="w-32 h-32 object-contain border border-gray-600 rounded-lg p-2 bg-gray-800">
                            </div>
                        @endif
                    </div>

                    <!-- Favicon -->
                    <div>
                        <x-ui.file-input wire:model="form.favicon" id="favicon" label="{{ __('Favicon') }}"
                            hint="{{ __('16x16') }}" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg"
                            :error="$errors->first('form.favicon')" />
                        
                        {{-- Current Favicon Preview --}}
                        @if(!empty($general_settings['favicon']) && !$form->favicon)
                            <div class="mt-3">
                                <p class="text-sm text-gray-400 mb-2">{{ __('Current Favicon:') }}</p>
                                <img src="{{ asset('storage/' . $general_settings['favicon']) }}" 
                                     alt="Favicon" 
                                     class="w-16 h-16 object-contain border border-gray-600 rounded-lg p-2 bg-gray-800">
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Row 2: App Name + Short Name -->
                <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- App Name -->
                    <div>
                        <x-ui.label value="{{ __('App Name') }}" />
                        <x-ui.input type="text" placeholder="{{ __('App Name') }}" wire:model="form.app_name" />
                        <x-ui.input-error :messages="$errors->get('form.app_name')" />
                    </div>

                    <!-- App Short Name -->
                    <div>
                        <x-ui.label value="{{ __('App Short Name') }}" />
                        <x-ui.input type="text" placeholder="{{ __('App Short Name') }}"
                            wire:model="form.short_name" />
                        <x-ui.input-error :messages="$errors->get('form.short_name')" />
                    </div>
                </div>

                <!-- Row 3: Timezone + Environment -->
                <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <!-- Timezone -->
                    <div>
                        <x-ui.label value="{{ __('Timezone') }}" />
                        <x-ui.select wire:model="form.timezone" class="select">
                            <option value="" hidden>{{ __('Select timezone') }}</option>
                            @foreach ($timezones as $timezone)
                                <option value="{{ $timezone['timezone'] }}">
                                    {{ $timezone['name'] }}
                                </option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('form.timezone')" />
                    </div>

                    <!-- Environment -->
                    <div>
                        <x-ui.label value="{{ __('Environment') }}" />
                        <x-ui.select wire:model="form.environment" class="select">
                            @foreach ($environment_infos as $key => $info)
                                <option value="{{ $key }}">{{ $info }}</option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('form.environment')" />
                    </div>

                </div>

                <!-- Row 4: App Debug -->
                <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <x-ui.label value="{{ __('App Debug') }}" />
                        <x-ui.select wire:model="form.app_debug" class="select">
                            @foreach ($app_debug_infos as $key => $info)
                                <option value="{{ $key }}">{{ $info }}</option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('form.app_debug')" />
                    </div>
                </div>

            </div>
            <!-- END SINGLE MAIN GRID -->

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button type="reset" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle" class="w-4 h-4" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="submit" class="w-auto! py-2!" wire:loading.attr="disabled">
                    <flux:icon name="check-circle" class="w-4 h-4" />
                    <span wire:loading.remove>{{ __('Save Settings') }}</span>
                    <span wire:loading>{{ __('Saving...') }}</span>
                </x-ui.button>
            </div>

        </form>
    </div>

</section>