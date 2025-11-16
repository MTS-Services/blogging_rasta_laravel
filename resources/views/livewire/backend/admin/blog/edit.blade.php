<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Blog Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.blog.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <div class="w-full col-span-2">
                <x-ui.file-input wire:model="form.file" label="{{ __('File') }}" :error="$errors->first('form.file')"
                    hint="Upload a file (Max: 2MB)" :existingFiles="$existingFile" />

            </div>

            <!-- Add other form fields here -->
            <div class="my-6 space-y-4 grid grid-cols-2 gap-5">
                <div class="w-full ">
                    <x-ui.label value="{{ __('Title') }}" class="mb-1" />
                    <x-ui.input type="text" placeholder="{{ __('Blog Title') }}" id="title"
                        wire:model="form.title" />
                    <x-ui.input-error :messages="$errors->get('form.title')" />
                </div>
                <div class="w-full">
                    <x-ui.label value="{{ __('Slug') }}" class="mb-1" />
                    <x-ui.input type="text" placeholder="{{ __('Blog Slug') }}" id="slug"
                        wire:model="form.slug" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" />
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
                    <x-ui.label value="Meta Title" class="mb-1" />
                    <x-ui.input type="text" placeholder="Meta Title" id="meta_title" wire:model="form.meta_title" />
                    <x-ui.input-error :messages="$errors->get('form.meta_title')" />
                </div>


            </div>

            {{-- meta description --}}
            <div class="w-full ">
                <x-ui.label value="{{ __('Meta Description') }}" class="mb-1" />
                <x-ui.text-editor model="form.meta_description" id="meta_description"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.description')" />
            </div>
            {{-- description --}}
            <div class="w-full mt-5">
                <x-ui.label value="{{ __('Description') }}" class="mb-1" />
                <x-ui.text-editor model="form.description" id="description"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.description')" />
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
