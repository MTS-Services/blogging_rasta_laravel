<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Admin Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.am.admin.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Profile Picture') }}
                </h3>
                <x-ui.file-input wire:model="form.avatar" label="Avatar" accept="image/*" :error="$errors->first('form.avatar')"
                    hint="Upload a profile picture (Max: 2MB)" />
            </div>

            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                <div class="w-full">
                    <x-ui.label value="Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Name" wire:model="form.name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Email" class="mb-1" />
                    <x-ui.input type="email" placeholder="Email Input" wire:model="form.email" />
                    <x-ui.input-error :messages="$errors->get('form.email')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Phone" class="mb-1" />
                    <x-ui.input type="tel" placeholder="Phone Input" wire:model="form.phone" />
                    <x-ui.input-error :messages="$errors->get('form.phone')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Status Select" class="mb-1" />
                    <x-ui.select wire:model="form.status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Password" class="mb-1" />
                    <x-ui.input type="password" placeholder="Password" wire:model="form.password" />
                    <x-ui.input-error :messages="$errors->get('form.password')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Confirm Password" class="mb-1" />
                    <x-ui.input type="password" placeholder="Confirm Password"
                        wire:model="form.password_confirmation" />
                    <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetForm" variant="tertiary"
                    class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button class="w-auto! py-2!" type="submit">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{__('Create
                        Admin')}}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{__('Creating...')}}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
