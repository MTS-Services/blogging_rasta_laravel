<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Language List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="" type='secondary' class="flex-1 sm:flex-none">
                    <flux:icon name="trash" class="w-4 h-4 stroke-white" />
                    <span class="sm:inline text-white">{{ __('Trash') }}</span>
                </x-ui.button>
                <x-ui.button wire:navigate href="{{ route('admin.language.create') }}" class="flex-1 sm:flex-none">
                    <flux:icon name="user-plus" class="w-4 h-4 stroke-white" />
                    <span class="sm:inline text-white">{{ __('Add') }}</span>
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}

</section>
