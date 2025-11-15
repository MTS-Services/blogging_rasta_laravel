<section>
    <div class="glass-card rounded-2xl p-6 md:col-span-5">

        @if (session()->has('success'))
            <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="updateSettings">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 h-fit">
                <div>
                    <x-ui.label value="{{ __('Database Driver') }}" />
                    <x-ui.select wire:model="form.database_driver">
                        <option value="">{{ __('Select Driver') }}</option>
                        @foreach ($database_driver_infos as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.database_driver')" />
                </div>

                <div>
                    <x-ui.label value="{{ __('Database Host') }}" />
                    <x-ui.input type="text" placeholder="{{ __('Database Host') }}"
                        wire:model="form.database_host" />
                    <x-ui.input-error :messages="$errors->get('form.database_host')" />
                </div>

                <div>
                    <x-ui.label value="{{ __('Database Port') }}" />
                    <x-ui.input type="text" placeholder="{{ __('Database Port') }}"
                        wire:model="form.database_port" />
                    <x-ui.input-error :messages="$errors->get('form.database_port')" />
                </div>

                <div>
                    <x-ui.label value="{{ __('Database Name') }}" />
                    <x-ui.input type="text" placeholder="{{ __('Database Name') }}"
                        wire:model="form.database_name" />
                    <x-ui.input-error :messages="$errors->get('form.database_name')" />
                </div>

                <div>
                    <x-ui.label value="{{ __('Database Username') }}" />
                    <x-ui.input type="text" placeholder="{{ __('Enter Username') }}"
                        wire:model="form.database_username" />
                    <x-ui.input-error :messages="$errors->get('form.database_username')" />
                </div>

                <div>
                    <x-ui.label value="{{ __('Database Password') }}" />
                    <x-ui.input type="password" placeholder="{{ __('Enter Password') }}"
                        wire:model="form.database_password" />
                    <x-ui.input-error :messages="$errors->get('form.database_password')" />
                </div>
            </div>

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
