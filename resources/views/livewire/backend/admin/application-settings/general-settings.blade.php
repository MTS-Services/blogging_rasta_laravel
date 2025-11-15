<section>
    {{-- Header --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-white">{{ __('General Settings') }}</h2>
            {{-- <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('app-settings.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div> --}}
        </div>
    </div>

    {{-- Settings Form --}}
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="updateSettings">
            <div class="grid grid-cols-1 2xl:grid-cols-9 gap-5">

                {{-- Left Section --}}
                <div class="2xl:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- App Name --}}
                    <div>
                        <x-ui.label value="{{ __('App Name') }}" />
                        <x-ui.input type="text" placeholder="{{ __('App Name') }}"
                            wire:model="form.app_name" />
                        <x-ui.input-error :messages="$errors->get('form.app_name')" />
                    </div>

                    {{-- App Short Name --}}
                    <div>
                        <x-ui.label value="{{ __('App Short Name') }}" />
                        <x-ui.input type="text" placeholder="{{ __('App Short Name') }}"
                            wire:model="form.short_name" />
                        <x-ui.input-error :messages="$errors->get('form.short_name')" />
                    </div>

                    {{-- Timezone --}}
                    <div>
                        <x-ui.label value="{{ __('Timezone') }}" />
                        {{-- <x-ui.select wire:model="form.timezone" class="select select2"> --}}
                        <x-ui.select wire:model="form.timezone" class="select">
                            <option value="" selected hidden>{{ __('Select timezone') }}</option>
                            @foreach ($timezones as $timezone)
                                <option value="{{ $timezone['timezone'] }}">
                                    {{ $timezone['name'] ?? '' }}
                                </option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('form.timezone')" />
                    </div>

                    {{-- Environment --}}
                    <div>
                        <x-ui.label value="{{ __('Environment') }}" />
                        <x-ui.select wire:model="form.environment" class="select">
                            @foreach (App\Models\ApplicationSetting::getEnvironmentInfos() as $key => $info)
                                <option value="{{ $key }}">
                                    {{ $info }}
                                </option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('form.environment')" />
                    </div>

                    {{-- App Debug --}}
                    <div>
                        <x-ui.label value="{{ __('App Debug') }}" />
                        <x-ui.select wire:model="form.app_debug" class="select">
                            @foreach (App\Models\ApplicationSetting::getAppDebugInfos() as $key => $info)
                                <option value="{{ $key }}">
                                    {{ $info }}
                                </option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('form.app_debug')" />
                    </div>

                    {{-- Debugbar --}}
                    <div>
                        <x-ui.label value="{{ __('Enable Debugbar') }}" />
                        <x-ui.select wire:model="form.debugbar" class="select">
                            @foreach (App\Models\ApplicationSetting::getDebugbarInfos() as $key => $info)
                                <option value="{{ $key }}">
                                    {{ $info }}
                                </option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input-error :messages="$errors->get('form.debugbar')" />
                    </div>

                    {{-- Date, Time, Theme --}}
                    <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-5">

                        <div>
                            <x-ui.label value="{{ __('Date Format') }}" />
                            <x-ui.select wire:model="form.date_format" class="select">
                                @foreach (App\Models\ApplicationSetting::getDateFormatInfos() as $key => $info)
                                    <option value="{{ $key }}">
                                        {{ $info }}
                                    </option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('form.date_format')" />
                        </div>

                        <div>
                            <x-ui.label value="{{ __('Time Format') }}" />
                            <x-ui.select wire:model="form.time_format" class="select">
                                @foreach (App\Models\ApplicationSetting::getTimeFormatInfos() as $key => $info)
                                    <option value="{{ $key }}">
                                        {{ $info }}
                                    </option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('form.time_format')" />
                        </div>

                        <div>
                            <x-ui.label value="{{ __('Default Theme Mode') }}" />
                            <x-ui.select wire:model="form.theme_mode" class="select">
                                @foreach (App\Models\ApplicationSetting::getThemeModeInfos() as $key => $info)
                                    <option value="{{ $key }}">
                                        {{ $info }}
                                    </option>
                                @endforeach
                            </x-ui.select>
                            <x-ui.input-error :messages="$errors->get('form.theme_mode')" />
                        </div>
                    </div>
                </div>

                {{-- Right Section (Logo & Favicon) --}}
                <div class="2xl:col-span-3 grid grid-cols-1 gap-5 h-fit">
                    <div>
                        <x-ui.file-input wire:model="form.app_logo" id="app_logo" label="{{ __('App Logo') }}"
                            hint="{{ __('Max: 400x400') }}" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg"
                            :error="$errors->first('form.app_logo')" />
                        
                        @if($form->app_logo && is_object($form->app_logo))
                            <div class="mt-2">
                                <img src="{{ $form->app_logo->temporaryUrl() }}" class="max-w-[200px] rounded">
                            </div>
                        @elseif(isset($general_settings['app_logo']))
                            <div class="mt-2">
                                <img src="{{ asset($general_settings['app_logo']) }}" class="max-w-[200px] rounded">
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-ui.file-input wire:model="form.favicon" id="favicon" label="{{ __('Favicon') }}"
                            hint="{{ __('16x16') }}" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg"
                            :error="$errors->first('form.favicon')" />
                        
                        @if($form->favicon && is_object($form->favicon))
                            <div class="mt-2">
                                <img src="{{ $form->favicon->temporaryUrl() }}" class="max-w-[50px] rounded">
                            </div>
                        @elseif(isset($general_settings['favicon']))
                            <div class="mt-2">
                                <img src="{{ asset($general_settings['favicon']) }}" class="max-w-[50px] rounded">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button type="reset" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="submit" class="w-auto! py-2!" wire:loading.attr="disabled">
                    <flux:icon name="check-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    <span wire:loading.remove>{{ __('Save Settings') }}</span>
                    <span wire:loading>{{ __('Saving...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>