<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Game Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.gm.game.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Category') }} <span class="text-red-500">*</span>
                    </label>
                    <x-ui.select wire:model="form.game_category_id"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach ($categories as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.game_category_id')" class="mt-2" />
                </div>

                {{-- Name --}}

                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Name') }} <span class="text-red-500">*</span>
                    </x-ui.label>
                    <x-ui.input type="text" wire:model="form.name" placeholder="{{ __('Game Name') }}"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>

                {{-- Status --}}


                <div>
                    <x-ui.label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </x-ui.label>
                    <x-ui.select wire:model="form.status"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600">
                        <option value="">{{ __('Select Status') }}</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.status')" class="mt-2" />
                </div>

                {{-- Developer --}}
                <div>
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Developer') }}</x-ui.label>
                    <x-ui.input type="text" wire:model="form.developer"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.developer')" class="mt-2" />
                </div>

                {{-- Publisher --}}
                <div>
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Publisher') }}</x-ui.label>
                    <x-ui.input type="text" wire:model="form.publisher"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.publisher')" class="mt-2" />
                </div>

                {{-- Release Date --}}

                <div>
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Release Date') }}</x-ui.label>
                    <x-ui.input type="date" wire:model="form.release_date"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                        <x-ui.input-error :messages="$errors->get('form.release_date')" class="mt-2" />
                </div>

                {{-- Platform (Checkbox) --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium dark:text-gray-300 mb-2">
                        {{ __('Platform') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @foreach (['PC', 'PS5', 'Xbox', 'Android', 'iOS'] as $platform)
                            <x-ui.label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="form.platform" value="{{ $platform }}">
                                {{ $platform }}
                            </x-ui.label>
                        @endforeach

                    </div>
                    <x-ui.input-error :messages="$errors->get('form.platform')" class="mt-2" />
                </div>

                {{-- Ends Platforms --}}
                {{-- Description --}}

                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Description') }}</x-ui.label>
                    <x-ui.textarea wire:model="form.description" rows="4"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></x-ui.textarea>
                    <x-ui.input-error :messages="$errors->get('form.description')" class="mt-2" />
                </div>

                {{-- Images --}}
                <div>
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Logo') }}</x-ui.label>
                    <x-ui.file-input type="file" wire:model="form.logo"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Banner') }}</x-ui.label>
                    <x-ui.file-input type="file" wire:model="form.banner"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.banner')" class="mt-2" />
                </div>

                <div>
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Thumbnail') }}</x-ui.label>
                    <x-ui.file-input type="file" wire:model="form.thumbnail"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.thumbnail')" class="mt-2" />
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Thumbnail') }}
                    </h3>
                    <x-ui.file-input wire:model="form.thumbnail" label="Game Thumbanail" accept="image/*"
                        :error="$errors->first('form.thumbnail')" hint="Upload a game thumbnail (Max: 2MB)" />
                </div>


                <div class="col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Banner') }}
                    </h3>
                    <x-ui.file-input wire:model="form.banner" label="Game Banner" accept="image/*" :error="$errors->first('form.banner')"
                        hint="Upload a game banner (Max: 2MB)" />
                </div>

                {{-- Boolean Checkboxes --}}
                <div class="flex gap-6 mt-3">
                    <x-ui.label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="form.is_featured"> {{ __('Featured') }}
                    </x-ui.label>
                    <x-ui.input-error :messages="$errors->get('form.is_featured')" class="mt-2" />
                    <x-ui.label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="form.is_trending"> {{ __('Trending') }}
                    </x-ui.label>
                    <x-ui.input-error :messages="$errors->get('form.is_trending')" class="mt-2" />
                </div>

                {{-- SEO Fields --}}
                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Title') }}</x-ui.label>
                    <x-ui.input type="text" wire:model="form.meta_title" placeholder="{{ __('Meta Title') }}"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600" />
                    <x-ui.input-error :messages="$errors->get('form.meta_title')" class="mt-2" />
                </div>

                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Description') }}</x-ui.label>
                    <x-ui.text-editor wire:model="form.meta_description" rows="3"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></x-ui.text-editor>
                    <x-ui.input-error :messages="$errors->get('form.meta_description')" class="mt-2" />
                </div>

                <div class="col-span-2">
                    <x-ui.label
                        class="block text-sm font-medium dark:text-gray-300 mb-2">{{ __('Meta Keywords') }}</x-ui.label>
                    <x-ui.textarea wire:model="form.meta_keywords" rows="2"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600"></x-ui.textarea>
                    <x-ui.input-error :messages="$errors->get('form.meta_keywords')" class="mt-2" />
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button wire:click.prevent="resetForm" type="danger" class="w-auto! py-2!" button
                    variant="tertiary">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Reset') }}
                </x-ui.button>

                <x-ui.button type="accent" button>
                    <span wire:loading.remove wire:target="save" class="text-white">{{ __('Create Game') }}</span>
                    <span wire:loading wire:target="save" class="text-white">{{ __('Creating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
