<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('User Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.tm.user.index') }}" class="w-auto py-2!">
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
                {{-- name --}}
                <div class="w-full">
                    <x-ui.label value="User Category" for="user_category_id" class="mb-1" />
                    <x-ui.select wire:model="form.user_category_id" id="user_category_id">
                        <option value="">{{ __('Select User Category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.user_category_id')" />
                </div>

                {{-- Name --}}
                <div class="w-full">
                    <x-ui.label value="Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Name" id="name" wire:model="form.name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Username" class="mb-1" />
                    <x-ui.input type="text" placeholder="Username" id="username" wire:model="form.username" />
                    <x-ui.input-error :messages="$errors->get('form.username')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="Max Video" class="mb-1" />
                    <x-ui.input type="number" placeholder="Max Video" id="max_videos" wire:model="form.max_videos" />
                    <x-ui.input-error :messages="$errors->get('form.max_videos')" />
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
