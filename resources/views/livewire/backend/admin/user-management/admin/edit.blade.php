<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Admin Edit') }}</h2>
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2">
                    <x-ui.button href="{{ route('admin.um.admin.index') }}" class="w-auto! py-2!">
                        <flux:icon name="arrow-left"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            <div>
                <x-ui.file-input wire:model="form.avatar" label="Profile Picture" accept="image/*" :error="$errors->first('form.avatar')"
                    hint="Upload a profile picture " :existingFiles="$existingFile" removeModel="form.remove_file" />
            </div>

            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                <div class="w-full col-span-2">
                    <x-ui.label value="{{ __('Name') }}" class="mb-1" />
                    <x-ui.input type="text" placeholder="{{ __('Full Name') }}" wire:model="form.name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="{{ __('Email') }}" class="mb-1" />
                    <x-ui.input type="email" placeholder="example@example.com" wire:model="form.email" />
                    <x-ui.input-error :messages="$errors->get('form.email')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="{{ __('Select Status') }}" class="mb-1" />
                    <x-ui.select wire:model="form.status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="{{ __('Password') }}" class="mb-1" />
                    <x-ui.input type="password" placeholder="*********" wire:model="form.password" />
                    <x-ui.input-error :messages="$errors->get('form.password')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="{{ __('Confirm Password') }}" class="mb-1" />
                    <x-ui.input type="password" placeholder="*********" wire:model="form.password_confirmation" />
                    <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                </div>
            </div>
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetForm" variant="tertiary" class="w-auto! py-2!">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    <span wire:loading.remove wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Reset') }}</span>
                    <span wire:loading wire:target="resetForm"
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Reseting...') }}</span>
                </x-ui.button>

                <x-ui.button type="submit" class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save" class="text-white">{{ __('Update Admin') }}</span>
                    <span wire:loading wire:target="save" class="text-white">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
