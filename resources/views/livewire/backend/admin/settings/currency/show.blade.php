<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Currency Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.as.currency.edit', $data->id) }}" variant="secondary"
                    class="w-auto py-2!">
                    <flux:icon name="pencil" class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                    {{ __('Edit') }}
                </x-ui.button>

                <x-ui.button href="{{ route('admin.as.currency.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />{{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 min-h-[500px]">
        <h3 class="text-2xl font-bold mb-1 text-gray-900 dark:text-white mb-4">
            {{ $data->name . ' (' . $data->code . ')' }}</h3>


        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Symbol')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $data->symbol }}</p>
            </div>

            {{-- Country Code --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Exchange Rate')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ number_format($data->exchange_rate, $data->decimal_places) }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Status')}}</p>
                <span
                    class="px-3 py-1 rounded-full text-xs font-bold inline-block badge badge-soft {{ $data->status->color() }}">
                    {{ $data->status->label() }}
                </span>
            </div>

            {{-- Is Default --}}
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Default Currency')}}</p>
                <span class="rounded-full text-xs font-bold inline-block">
                    {{ $data->is_default ? __('Yes') : __('No') }}
                </span>
            </div>

            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Created Date')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->created_at_formatted }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Updated Date')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->updated_at_formatted ?? 'N/A' }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Deleted Date')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->deleted_at_formatted ?? 'N/A' }}</p>
            </div>

            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Created By')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->creater_admin?->name ?? 'N/A' }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Updated By')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->updater_admin?->name ?? 'N/A' }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Deleted By')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->deleter_admin?->name ?? 'N/A' }}</p>
            </div>


        </div>
    </div>
</div>
