<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Language Create') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.language.index') }}">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="save">
            {{-- <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Profile Picture') }}
                </h3>
                <x-ui.file-input wire:model="form.avatar" label="Avatar" accept="image/*" :error="$errors->first('form.avatar')"
                    hint="Upload a profile picture (Max: 2MB)" />
            </div> --}}

            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                {{-- locale --}}
                <div class="w-full">
                    <x-ui.label value="Locale" class="mb-1" />
                    <x-ui.input type="text" placeholder="Locale" wire:model="form.locale" />
                    <x-ui.input-error :messages="$errors->get('form.locale')" />
                </div>

                {{-- Name --}}
                <div class="w-full">
                    <x-ui.label value="Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Name" wire:model="form.name" />
                    <x-ui.input-error :messages="$errors->get('form.name')" />
                </div>

                {{-- native_name --}}
                <div class="w-full">
                    <x-ui.label value="Native Name" class="mb-1" />
                    <x-ui.input type="text" placeholder="Native Name" wire:model="form.native_name" />
                    <x-ui.input-error :messages="$errors->get('form.native_name')" />
                </div>

                {{-- status --}}
                <div class="w-full">
                    <x-ui.label value="Status" class="mb-1" />

                    <div class="flex items-center gap-4">
                        @foreach ($statuses as $status)
                            <label class="flex items-center gap-1 cursor-pointer text-zinc-500">
                                <input type="radio" class="radio radio-zinc-500 ext-zinc-400" name="status"
                                    wire:model="form.status" value="{{ $status['value'] }}"
                                    {{ $status['value'] === 'active' ? 'checked' : '' }}>
                                <span class="text-zinc-400">{{ $status['label'] }}</span>
                            </label>
                        @endforeach
                    </div>

                    <x-ui.input-error :messages="$errors->get('form.status')" />
                </div>

                {{-- is_active --}}
                <div class="w-full">
                    <x-ui.label value="Is Active" class="mb-1" />

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-1 cursor-pointer text-zinc-500">
                            <input type="radio" class="radio radio-zinc-500 text-zinc-400" name="is_active"
                                wire:model="form.is_active" value="1" checked>
                            <span class="text-zinc-400">{{__('Active')}}</span>
                        </label>

                        <label class="flex items-center gap-1 cursor-pointer text-zinc-500">
                            <input type="radio" class="radio text-zinc-400" name="is_active"
                                wire:model="form.is_active" value="0">
                            <span class="text-zinc-400">{{__('Inactive')}}</span>
                        </label>
                    </div>

                    <x-ui.input-error :messages="$errors->get('form.is_active')" />
                </div>

                {{-- direction --}}
                <div class="w-full">
                    <x-ui.label value="Direction" class="mb-1" />

                    <div class="flex items-center gap-4">
                        @foreach ( $dirations as $diration )
                            <input type="radio" class="radio radio-zinc-500 text-zinc-400" name="direction"
                                wire:model="form.direction" value="{{ $diration['value'] }}"
                                {{ $diration['value'] === 'ltr' ? 'checked' : '' }}>
                            <span class="text-zinc-400">{{__('LTR')}}</span>
                        @endforeach
                    </div>

                    <x-ui.input-error :messages="$errors->get('form.direction')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-6">
                <x-ui.button href="{{ route('admin.language.index') }}" type="danger">
                    <flux:icon name="x-circle" class="w-4 h-4 stroke-white" />
                    {{ __('Cancel') }}
                </x-ui.button>

                <x-ui.button type="accent" button>
                    <span wire:loading.remove wire:target="save" class="text-white">{{__('Create User')}}</span>
                    <span wire:loading wire:target="save" class="text-white">{{__('Creating...')}}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
