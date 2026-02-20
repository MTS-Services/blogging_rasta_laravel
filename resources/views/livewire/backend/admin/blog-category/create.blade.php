<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Blog Category Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.blog-category.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="mx-auto glass-card w-xl rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <div class="mt-6 space-y-4 gap-5">
                <div>
                    <x-ui.label for="title" :value="__('Title')" />
                    <x-ui.input id="title" type="text" class="mt-1 block w-full" wire:model="form.title"
                        placeholder="{{ __('Category title') }}" />
                    <x-ui.input-error :messages="$errors->get('form.title')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="slug" :value="__('Slug')" />
                    <x-ui.input id="slug" type="text" class="mt-1 block w-full" wire:model="form.slug"
                        placeholder="{{ __('category-slug') }}" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="status" :value="__('Status')" />
                    <x-ui.select wire:model="form.status">
                        <option value="active">{{ __('Active') }}</option>
                        <option value="inactive">{{ __('Inactive') }}</option>
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 space-y-4 gap-5">
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
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Create') }}</span>
                        <span wire:loading wire:target="save"
                            class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Saving...') }}</span>
                    </x-ui.button>
                </div>
            </div>

        </form>
    </div>
</section>
