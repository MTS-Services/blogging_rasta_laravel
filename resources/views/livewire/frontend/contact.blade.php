<div>
    <div class=" font-sans text-slate-800">
        <main class="min-h-screen flex items-center justify-center p-6">
            <section
                class="w-full max-w-6xl bg-bg-tertiary rounded-2xl shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">

                <div class="relative md:order-1 order-2">
                    <div id="slider" class="h-96 md:h-full">
                        </div>

                    <button id="prevBtn" aria-label="Previous"
                        class="absolute top-1/2 -translate-y-1/2 z-20 bg-white/70 rounded-xl backdrop-blur-sm p-2 ">
                        <img src="{{ asset('/assets/images/blog_page/image 6.png') }}"
                            class="lg:h-140 lg:w-200 sm:w-full sm:h-full" alt="">
                    </button>

                    <div id="indicators" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-20"></div>
                </div>

                <div class="p-8 md:p-12 flex flex-col justify-center md:order-2 order-1">
                    <h2 class="text-3xl font-semibold mb-2">{{ __('Contact Us') }}</h2>
                    <p class="text-text-secondary mb-6">
                        {{ __("We'd love to hear from you. Slide through some of our locations and reach out using the form below or via the listed contact methods.") }}
                    </p>

                    <div id="slideContent" class="space-y-6">
                        </div>

                    <form wire:submit.prevent="save" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="w-full">
                            <x-ui.label value="Your Name" class="mb-1" />
                            <x-ui.input type="text" placeholder="Your name" wire:model="form.name" />
                            <x-ui.input-error :messages="$errors->get('form.name')" />
                        </div>

                        <div class="w-full ">
                            <x-ui.label value="Email" class="mb-1" />
                            <x-ui.input type="email" placeholder="Email" wire:model="form.email" />
                            <x-ui.input-error :messages="$errors->get('form.email')" />
                        </div>

                        <div class="w-full col-span-1 sm:col-span-2">
                            <x-ui.label value="Message" class="mb-1" />
                            <textarea id="message-input"
                                class="w-full p-4 text-base min-h-[140px] border-2 border-zinc-200 rounded-xl
                                    focus:ring-2 focus:ring-zinc-500 focus:border-zinc-500 transition duration-200"
                                placeholder="Message" wire:model="form.message">
                                </textarea>

                            <x-ui.input-error :messages="$errors->get('form.message')" />
                        </div>

                        <x-ui.button type="submit" wire:target="save" wire:loading.attr="disabled"
                            class="font-medium col-span-1 sm:col-span-2 inline-flex items-center justify-center gap-2 rounded-lg mt-2">
                            
                            <span wire:loading wire:target="save" class="animate-spin h-5 w-5 border-t-2 border-b-2 border-white rounded-full"></span>
                            
                            <span wire:loading.remove wire:target="save" class="text-text-white">{{ __('Send Message') }}</span>
                            
                            <flux:icon name="arrow-right" wire:loading.remove wire:target="save" class="w-4 h-4 text-white fill-white! stroke-white!" />
                        </x-ui.button>

                    </form>


                    <div class="mt-6 text-sm text-slate-500">
                        <p><strong>{{ __('Phone:') }}</strong> +1 (555) 123-4567</p>
                        <p><strong>{{ __('Email:') }}</strong> hello@example.com</p>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>