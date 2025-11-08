<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Category Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.category.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="update">

            <!-- Add other form fields here -->
            {{-- <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Icon') }}
                </h3>
                <x-ui.file-input wire:model="form.icon" label="Icon" accept="image/*" :error="$errors->first('form.icon')"
                    hint="Upload a profile picture (Max: 1MB) height: 200px width: 200px" />

                @error('form.icon.*')
                    <span class="error">{{ $message }}</span>
                @enderror

            </div> --}}


            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Icon') }}
                </h3>

                {{-- Show existing icon from database (only in edit mode) --}}
                @if ($form->isUpdating() && $form->id)
                    @php
                        $category = \App\Models\GameCategory::find($form->id);
                    @endphp

                    @if ($category && $category->icon)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current Icon:</p>
                            <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                class="h-24 w-24 object-cover rounded border-2 border-gray-300 dark:border-gray-600">
                        </div>
                    @endif
                @endif

                <x-ui.file-input wire:model="form.icon" label="Icon" accept="image/*" :error="$errors->first('form.icon')"
                    hint="Upload an icon (Max: 1MB, Max dimensions: 200x200px)" />

                @error('form.icon')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror

                {{-- Show preview of newly uploaded icon (before saving) --}}
                @if ($form->icon && is_object($form->icon))
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">New Icon Preview:</p>
                        <img src="{{ $form->icon->temporaryUrl() }}" alt="New icon preview"
                            class="h-24 w-24 object-cover rounded border-2 border-green-300 dark:border-green-600">
                    </div>
                @endif
            </div>


            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                {{-- title --}}
                <div class="w-full">
                    <x-ui.label value="Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Name" id="title" wire:model="form.name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" />
                </div>

                {{-- slug --}}
                <div class="w-full">
                    <x-ui.label value="Slug" class="mb-1" />
                    <x-ui.input type="text" placeholder="Slug" id="slug" wire:model="form.slug" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" />
                </div>

                {{-- meta title --}}
                <div class="w-full">
                    <x-ui.label value="Meta Title" class="mb-1" />
                    <x-ui.input type="text" placeholder="Meta Title" id="meta_title" wire:model="form.meta_title" />
                    <x-ui.input-error :messages="$errors->get('form.meta_title')" />
                </div>

                {{-- status --}}
                <div class="w-full">
                    <x-ui.label value="Status" class="mb-1" />
                    <x-ui.select wire:model="form.status">

                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" />
                </div>



            </div>
            {{-- description --}}
            <div class="w-full mt-2">
                <x-ui.label value="Description" class="mb-1" />
                <x-ui.text-editor model="form.description" id="text-editor-main-content"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.description')" />
            </div>

            {{-- meta description --}}
            {{-- <div class="w-full mt-2">
                <x-ui.label value="Meta Description" class="mb-1" />
                <x-ui.text-editor model="form.meta_description" id="text-editor-main-content"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.meta_description')" />
            </div> --}}

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button href="{{ route('admin.gm.category.index') }}" type="danger" class="w-auto! py-2!"
                    variant="tertiary">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Cancel') }}
                </x-ui.button>

                <x-ui.button type="accent" class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save" class="text-white">{{ __('Update Category') }}</span>
                    <span wire:loading wire:target="save" class="text-white">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
