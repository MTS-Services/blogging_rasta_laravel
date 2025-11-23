<section>
     @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Product Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.pm.product.index') }}" class="w-auto py-2!">
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
                    {{ __('Image') }}
                </h3>
                <x-ui.file-input wire:model="form.image" label="Image" accept="image/*" :error="$errors->first('form.image')"
                    hint="Upload a Image (Max: 2MB)" />
            </div>
            <!-- Fields -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">
                {{-- category_id --}}
                <div class="w-full">
                    <x-ui.label value="category" for="category_id" class="mb-1" />
                    <x-ui.select wire:model="form.category_id" id="category_id">
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.input-error :messages="$errors->get('form.category_id')" />
                </div>
                {{-- name --}}
                <div>
                    <x-ui.label for="title" :value="__('Title')" />
                    <x-ui.input id="title" type="text" class="mt-1 block w-full" wire:model="form.title"
                        placeholder="Enter Product Title" />
                    <x-ui.input-error :messages="$errors->get('form.title')" class="mt-2" />
                </div>

                {{-- slug --}}
                <div class="w-full">
                    <x-ui.label value="Slug" class="mb-1" />
                    <x-ui.input type="text" placeholder="Slug" id="slug" wire:model="form.slug" />
                    <x-ui.input-error :messages="$errors->get('form.slug')" />
                </div>
                {{-- price --}}
                <div class="w-full">
                    <x-ui.label value="Price" class="mb-1" />
                    <x-ui.input type="number" placeholder="Eneter Product Price" id="price"
                        wire:model="form.price" />
                    <x-ui.input-error :messages="$errors->get('form.price')" />
                </div>
                {{-- sale_price --}}
                <div class="w-full">
                    <x-ui.label value="Sale Price" class="mb-1" />
                    <x-ui.input type="number" placeholder="Eneter Product Sale Price" id="sale_price"
                        wire:model="form.sale_price" />
                    <x-ui.input-error :messages="$errors->get('form.sale_price')" />
                </div>
                {{-- product_types --}}
                <div class="w-full">
                    <x-ui.label value="Product Types" class="mb-1" />

                    <div
                        class="border rounded-md p-2 min-h-[42px] flex flex-wrap gap-2 items-center border-zinc-300 focus-within:ring-zinc-300 focus-within:border-zinc-300">
                        <!-- Display existing tags -->
                        @if (!empty($form->product_types))
                            @foreach ($form->product_types as $index => $type)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-zinc-100 text-second-500">
                                    {{ $type }}
                                    <button type="button" wire:click="removeProductType({{ $index }})"
                                        class="ml-2 text-second-500 hover:text-second-700 font-bold">
                                        ×
                                    </button>
                                </span>
                            @endforeach
                        @endif

                        <!-- Input field (inline with tags) -->
                        <input type="text" placeholder="Type and press Enter..." wire:model="productTypeInput"
                            wire:keydown.enter.prevent="addProductType"
                            class="border-0 focus:ring-0 outline-none flex-1 min-w-[150px] text-sm p-1 bg-transparent" />
                    </div>

                    <x-ui.input-error :messages="$errors->get('form.product_types')" />
                </div>

                {{-- affiliate_link --}}
                <div class="w-full">
                    <x-ui.label value="Affiliate Link" class="mb-1" />
                    <x-ui.input type="text" placeholder="Eneter Affiliate Link" id="affiliate_link"
                        wire:model="form.affiliate_link" />
                    <x-ui.input-error :messages="$errors->get('form.affiliate_link')" />
                </div>
                {{-- affiliate_source --}}
                <div class="w-full">
                    <x-ui.label value="Affiliate Source" class="mb-1" />
                    <x-ui.input type="text" placeholder="Eneter Affiliate Source" id="affiliate_source"
                        wire:model="form.affiliate_source" />
                    <x-ui.input-error :messages="$errors->get('form.affiliate_source')" />
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
            {{-- description --}}
            <div class="w-full mt-2">
                <x-ui.label value="Description" class="mb-1" />
                <x-ui.text-editor model="form.description" id="text-editor-main-content"
                    placeholder="Enter your main content here..." :height="350" />

                <x-ui.input-error :messages="$errors->get('form.description')" />
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
