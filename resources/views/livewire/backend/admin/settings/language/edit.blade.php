<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Language Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.as.language.index') }}">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <!-- Language Fields -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">


                <!-- Name -->
                <div>
                    <x-ui.label for="name" :value="__('Name')" required />
                    <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
                        placeholder="English, Spanish, French" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>

                <!-- Locale -->
                <div>
                    <x-ui.label for="locale" :value="__('Locale')" required />
                    <x-ui.input id="locale" type="text" class="mt-1 block w-full" wire:model="form.locale"
                        placeholder="en, es, fr, bn" />
                    <x-ui.input-error :messages="$errors->get('form.locale')" class="mt-2" />
                </div>

                <!-- Native Name -->
                <div>
                    <x-ui.label for="native_name" :value="__('Native Name')" />
                    <x-ui.input id="native_name" type="text" class="mt-1 block w-full" wire:model="form.native_name"
                        placeholder="English, Español, Français" />
                    <x-ui.input-error :messages="$errors->get('form.native_name')" class="mt-2" />
                </div>

                <!-- Country Code with Flag Preview -->
                <div>
                    <x-ui.label for="country_code" :value="__('Country Code')" required />
                    <div class="flex gap-2">
                        <x-ui.input id="country_code" type="text" class="mt-1 block w-full lowercase"
                            wire:model.live.debounce.300ms="form.country_code" placeholder="us, es, fr, bd"
                            maxlength="2" />
                        @if ($form->country_code)
                            <div
                                class="mt-1 flex items-center justify-center w-16 h-10 border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-800">
                                <img src="https://flagcdn.com/{{ strtolower($form->country_code) }}.svg"
                                    alt="{{ $form->country_code }} flag" class="w-full h-full object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="hidden items-center justify-center w-full h-full text-gray-400 text-xs">
                                    N/A
                                </div>
                            </div>
                        @endif
                    </div>
                    <x-ui.input-error :messages="$errors->get('form.country_code')" class="mt-2" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Enter 2-letter ISO country code (e.g., us, gb, bd)') }}</p>
                </div>

                <!-- Direction (Dynamic from Enum) -->
                <div>
                    <x-ui.label for="direction" :value="__('Text Direction')" required />
                    <x-ui.select id="direction" class="mt-1 block w-full" wire:model="form.direction">
                        <option value="">{{ __('Select Direction') }}</option>
                        @foreach ($directions as $direction)
                            <option value="{{ $direction['value'] }}">{{ $direction['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.direction')" class="mt-2" />
                </div>

                <!-- Status (Dynamic from Enum) -->
                <div>
                    <x-ui.label for="status" :value="__('Status')" required />
                    <x-ui.select id="status" class="mt-1 block w-full" wire:model="form.status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>

                <!-- Is Default -->
                <div>
                    <x-ui.label for="is_default" :value="__('Is Default Language?')" required />
                    <x-ui.select id="is_default" class="mt-1 block w-full" wire:model="form.is_default">
                        <option value="">{{ __('Select Option') }}</option>
                        <option value="1">{{ __('Yes') }}</option>
                        <option value="0">{{ __('No') }}</option>
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.is_default')" class="mt-2" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button href="{{ route('admin.as.language.index') }}" type="danger">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Cancel') }}
                </x-ui.button>

                <x-ui.button type="accent" button>
                    <span wire:loading.remove wire:target="save" class="text-white">{{ __('Update ') }}</span>
                    <span wire:loading wire:target="save" class="text-white">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
