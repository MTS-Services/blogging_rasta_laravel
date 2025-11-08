<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Edit') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.game.index') }}">

                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}

                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="update" enctype="multipart/form-data">
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">



                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Category') }} <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="form.game_category_id"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach ($categories as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('form.game_category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Name --}}

                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="form.name"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Status --}}


                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="form.status"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                    @error('form.status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Developer --}}


                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Developer') }}</label>
                    <input type="text" wire:model="form.developer"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.developer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Publisher --}}
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Publisher') }}</label>
                    <input type="text" wire:model="form.publisher"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.publisher')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Release Date --}}

                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Release Date') }}</label>
                    <input type="date" wire:model="form.release_date"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.release_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Platform (Checkbox) --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Platform') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @foreach (['PC', 'PS5', 'Xbox', 'Android', 'iOS'] as $platform)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="form.platform" value="{{ $platform }}">
                                {{ $platform }}
                            </label>
                        @endforeach

                    </div>
                    @error('form.platform')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Ends Platforms --}}
                {{-- Description --}}

                <div class="col-span-2">
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Description') }}</label>

                    <textarea wire:model="form.description" rows="4"                        
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></textarea>
                    @error('form.description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Images --}}


                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Logo') }}</label>
                    <input type="file" wire:model="form.logo"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Banner') }}</label>
                    <input type="file" wire:model="form.banner"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.banner')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Thumbnail') }}</label>
                    <input type="file" wire:model="form.thumbnail"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Boolean Checkboxes --}}
                <div class="flex gap-6 mt-3">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="form.is_featured">
                        {{ __('Featured') }}
                    </label>
                    @error('form.is_featured')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="form.is_trending">
                        {{ __('Trending') }}
                    </label>
                    @error('form.is_trending')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- SEO Fields --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Title') }}</label>
                    <input type="text" wire:model="form.meta_title"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                    @error('form.meta_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                <div class="col-span-2">
                    <label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Description') }}</label>

                    <textarea wire:model="form.meta_description" rows="3"                        
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></textarea>
                    @error('form.meta_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Keywords') }}</label>

                    <textarea wire:model="form.meta_keywords" rows="2"                        
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></textarea>
                    @error('form.meta_keywords')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button href="{{ route('admin.gm.game.index') }}" type="danger">

                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />

                    {{ __('Cancel') }}

                </x-ui.button>

                <x-ui.button type="accent" button>
                    <span wire:loading.remove wire:target="update" class="text-white">{{ __('Update Game') }}</span>
                    <span wire:loading wire:target="update" class="text-white">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
