<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Banner Video Edit') }}</h2>
            {{-- <div class="flex items-center gap-2">
                <div class="flex items-center gap-2">
                    <x-ui.button href="{{ route('admin.um.admin.index') }}" class="w-auto! py-2!">
                        <flux:icon name="arrow-left"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        {{ __('Back') }}
                    </x-ui.button>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="update">
            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">


                <div class="w-full col-span-2">
                    <x-ui.file-input wire:model="form.thumbnail" label="{{ __('Thumbnail') }}" accept="image/*"
                        :error="$errors->first('form.thumbnail')" hint="Upload a profile picture ( Formats: JPG, PNG, GIF, WebP) "
                        :existingFiles="$existingThumbnail" removeModel="form.removeThumbnail" />
                </div>

                <div class="w-full col-span-2">
                    <x-ui.file-input wire:model="form.file" label="{{ __('File') }}"
                        :error="$errors->first('form.file')" hint="Upload a profile picture ( Formats: MP4, WebM)"
                        :existingFiles="$existingFile" removeModel="form.removeFile" />
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
                    <span wire:loading.remove wire:target="update" class="text-white">{{ __('Update Banner') }}</span>
                    <span wire:loading wire:target="update" class="text-white">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
