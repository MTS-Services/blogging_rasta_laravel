<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('User Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.index') }}" class="w-auto! py-2!">
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

                {{-- first_name --}}
                <div class="w-full">
                    <x-ui.label value="First Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="First Name" wire:model="form.first_name" />
                    <x-ui.input-error :messages="$errors->get('form.first_name')" />
                </div>

                {{-- Last Name --}}
                <div class="w-full">
                    <x-ui.label value="Last Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Last Name" wire:model="form.last_name" />
                    <x-ui.input-error :messages="$errors->get('form.last_name')" />
                </div>

                {{-- user name --}}
                <div class="w-full">
                    <x-ui.label value="User Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="User Name" wire:model="form.username" />
                    <x-ui.input-error :messages="$errors->get('form.username')" />
                </div>
                {{-- display name --}}
                {{-- <div class="w-full">
                    <x-ui.label value="Display Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Display Name" wire:model="form.display_name" />
                    <x-ui.input-error :messages="$errors->get('form.display_name')" />
                </div> --}}
                {{-- date_of_birth --}}
                <div class="w-full">
                    <x-ui.label value="Date Of Birth" class="mb-1" />
                    <x-ui.input type="date" wire:model="form.date_of_birth" />
                    <x-ui.input-error :messages="$errors->get('form.date_of_birth')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Country Select" class="mb-1" />
                    <x-ui.select wire:model="form.country_id">
                        @foreach ($countries as $country)
                            <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.country_id')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Langugae" class="mb-1" />
                    <x-ui.select wire:model="form.language">
                        @foreach ($languages as $language)
                            <option value="{{ $language['id'] }}">{{ $language['name'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.language')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Email" class="mb-1" />
                    <x-ui.input type="email" placeholder="Email" wire:model="form.email" />
                    <x-ui.input-error :messages="$errors->get('form.email')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Phone" class="mb-1" />
                    <x-ui.input type="tel" placeholder="Phone" wire:model="form.phone" />
                    <x-ui.input-error :messages="$errors->get('form.phone')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Status Select" class="mb-1" />
                    <x-ui.select wire:model="form.account_status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.account_status')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Password" class="mb-1" />
                    <x-ui.input type="password" placeholder="Password" wire:model="form.password" />
                    <x-ui.input-error :messages="$errors->get('form.password')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Password Confirmation" class="mb-1" />
                    <x-ui.input type="password" placeholder="Password Confirmation"
                        wire:model="form.password_confirmation" />
                    <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button class="w-auto! py-2!" type="submit">
                    <span wire:loading.remove wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{__('Create
                        User')}}</span>
                    <span wire:loading wire:target="save"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{__('Creating...')}}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
