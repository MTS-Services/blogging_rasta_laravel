<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Category Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.category.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">

            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Icon') }}
                </h3>
                <x-ui.file-input wire:model="form.icon" label="Icon" accept="image/*" :error="$errors->first('form.icon')"
                    hint="Upload a profile picture (Max: 1MB) height: 200px width: 200px" />

                @error('form.icon.*')
                    <span class="error">{{ $message }}</span>
                @enderror

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

            {{-- meta description --}}
            <div class="w-full mt-2">
                <x-ui.label value="Meta Description" class="mb-1" />
                <x-ui.text-editor model="form.meta_description" id="meta_description"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.description')" />
            </div>
            {{-- description --}}
            <div class="w-full mt-2">
                <x-ui.label value="Description" class="mb-1" />
                <x-ui.text-editor model="form.description" id="description"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.description')" />
            </div>
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click="resetFrom" variant="tertiary" class="w-auto! py-2! ">
                    <flux:icon name="x-circle"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-tertiary" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="accent" class="w-auto! py-2!">
                    <span wire:loading.remove wire:target="save" class="text-white">{{ __('Create Category') }}</span>
                    <span wire:loading wire:target="save" class="text-white">{{ __('Creating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>

    @push('scripts')
        {{-- Auto slug script --}}
        <script>
            document.addEventListener('livewire:navigate', function() {
                document.getElementById('name').addEventListener('input', function() {
                    let slug = this.value
                        .toLowerCase()
                        .trim()
                        .replace(/\s+/g, '-');
                    document.getElementById('slug').value = slug;

                    document.getElementById('slug').dispatchEvent(new Event('input'));
                });
            })
        </script>
    @endpush
</section>
