<section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/ckEditor.css') }}">
    @endpush
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('About CMS') }}</h2>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <form wire:submit="update">
            <!-- Add other form fields here -->
            <div class="mt-6 space-y-4 grid grid-cols-2 gap-5">

                <div class="w-full col-span-2">
                    <x-ui.file-input accept="video/*" wire:model="form.banner_video" label="{{ __('Banner Video') }}"
                        :error="$errors->first('form.banner_video')" hint="Upload a profile picture ( Formats: MP4, WebM)" :existingFiles="$existingBannerVideo"
                        removeModel="form.removeBannerVideo" />
                </div>

                <div class="col-span-2">
                    <x-ui.label for="contact_email" :value="__('Contact Email')" />
                    <x-ui.input id="contact_email" type="text" class="mt-1 block w-full"
                        wire:model="form.contact_email" placeholder="Enter Title" />
                    <x-ui.input-error :messages="$errors->get('form.contact_email')" class="mt-2" />
                </div>

                {{-- title --}}
                <div>
                    <x-ui.label for="title_en" :value="__('Title (EN)')" />
                    <x-ui.input id="title_en" type="text" class="mt-1 block w-full" wire:model="form.title_en"
                        placeholder="Enter Title" />
                    <x-ui.input-error :messages="$errors->get('form.title_en')" class="mt-2" />
                </div>
                <div>
                    <x-ui.label for="title_fr" :value="__('Title (FR)')" />
                    <x-ui.input id="title_fr" type="text" class="mt-1 block w-full" wire:model="form.title_fr"
                        placeholder="Enter Title" />
                    <x-ui.input-error :messages="$errors->get('form.title_fr')" class="mt-2" />
                </div>



                {{-- about --}}
                <div class="w-full mt-2 col-span-2">
                    <x-ui.label value="About (EN)" class="mb-1" />
                    <x-ui.text-editor model="form.about_us_en" id="about_us_en" placeholder="Enter about us..."
                        :height="350" />

                    <x-ui.input-error :messages="$errors->get('form.about_us_en')" />
                </div>
                <div class="w-full mt-2 col-span-2">
                    <x-ui.label value="About (FR)" class="mb-1" />
                    <x-ui.text-editor model="form.about_us_fr" id="about_us_fr" placeholder="Enter about us..."
                        :height="350" />

                    <x-ui.input-error :messages="$errors->get('form.about_us_fr')" />
                </div>


                {{-- mission title --}}
                <div class="w-full mt-2">
                    <x-ui.label for="mission_title_en" :value="__('Mission Title (EN)')" />
                    <x-ui.input id="mission_title_en" type="text" class="mt-1 block w-full"
                        wire:model="form.mission_title_en" placeholder="Enter mission title" />
                    <x-ui.input-error :messages="$errors->get('form.mission_title_en')" class="mt-2" />
                </div>
                <div class="w-full mt-2">
                    <x-ui.label for="mission_title_fr" :value="__('Mission Title (FR)')" />
                    <x-ui.input id="mission_title_fr" type="text" class="mt-1 block w-full"
                        wire:model="form.mission_title_fr" placeholder="Enter mission title" />
                    <x-ui.input-error :messages="$errors->get('form.mission_title_fr')" class="mt-2" />
                </div>



                {{-- mission --}}
                <div class="w-full mt-2 col-span-2">
                    <x-ui.label value="Mission (EN)" class="mb-1" />
                    <x-ui.text-editor model="form.mission_en" id="mission_en" placeholder="Enter mission..."
                        :height="350" />

                    <x-ui.input-error :messages="$errors->get('form.mission_en')" />
                </div>
                <div class="w-full mt-2 col-span-2">
                    <x-ui.label value="Mission (FR)" class="mb-1" />
                    <x-ui.text-editor model="form.mission_fr" id="mission_fr" placeholder="Enter mission..."
                        :height="350" />

                    <x-ui.input-error :messages="$errors->get('form.mission_fr')" />
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
                    <span wire:loading.remove wire:target="update" class="text-white">{{ __('Update') }}</span>
                    <span wire:loading wire:target="update" class="text-white">{{ __('Updating...') }}</span>
                </x-ui.button>
            </div>
        </form>
    </div>
</section>
