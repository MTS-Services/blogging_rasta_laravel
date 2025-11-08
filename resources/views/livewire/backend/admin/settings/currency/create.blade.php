<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Currency Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.as.currency.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <!-- Fields -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                <div>
                    <x-ui.label for="name" :value="__('Name')" />
                    <x-ui.input id="name" type="text" class="mt-1 block w-full" wire:model="form.name"
                        placeholder="US Dollar, Euro, British Pound, Bangladeshi Taka" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="code" :value="__('Code')" />
                    <x-ui.input id="code" type="text" class="mt-1 block w-full" wire:model="form.code"
                        placeholder="USD, EUR, GBP, BDT" />
                    <x-ui.input-error :messages="$errors->get('form.code')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="symbol" :value="__('Symbol')" />
                    <x-ui.input id="symbol" type="text" class="mt-1 block w-full" wire:model="form.symbol"
                        placeholder="&\#xa3;, &\#xa2;, &\#x24;" />
                    <x-ui.input-error :messages="$errors->get('form.symbol')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="exchange_rate" :value="__('Exchange Rate')" />
                    <x-ui.input id="exchange_rate" type="text" class="mt-1 block w-full"
                        wire:model="form.exchange_rate" placeholder="Enter exchange rate. e.g. 100" />
                    <x-ui.input-error :messages="$errors->get('form.exchange_rate')" class="mt-2" />
                </div>
            </div>
            <div class="mt-6 space-y-4 grid grid-cols-3 gap-5">
                <div>
                    <x-ui.label for="decimal_places" :value="__('Decimal Places')" />
                    <x-ui.input id="decimal_places" type="number" class="mt-1 block w-full"
                        wire:model="form.decimal_places" placeholder="Enter decimal places. e.g. 2" />
                    <x-ui.input-error :messages="$errors->get('form.decimal_places')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="status" :value="__('Status')" />
                    <x-ui.select id="status" class="mt-1 block w-full" wire:model="form.status">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
                <div class="form-control w-full">
                    <x-ui.label for="is_default" :value="__('Is Default Currency?')" />

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
                <x-ui.button wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    <span wire:loading.remove wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reset') }}</span>
                    <span wire:loading wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-tertiary">{{ __('Reseting...') }}</span>
                </x-ui.button>

                <x-ui.button class="w-auto! py-2!" type="submit">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Create ') }}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Saving...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
