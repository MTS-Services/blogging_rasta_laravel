<div>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Audit Log Details') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <x-ui.button href="{{ route('admin.alm.audit.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />{{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 min-h-[500px]">

        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Event')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $data->event }}</p>
            </div>

            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Auditable')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->auditable_type }}</p>
            </div>

            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('IP Address')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->ip_address }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('User Agent')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->user_agent }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Tag')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->tags }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('URL')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->url }}</p>
            </div>

            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Audit By')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->user?->name }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-gray-500 dark:text-gray-400">{{__('Audit Date')}}</p>
                <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">
                    {{ $data->created_at_formatted }}</p>
            </div>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <h3 class="col-span-4 text-2xl font-bold mb-1 text-gray-900 dark:text-white my-4">{{__('Old Datas')}}</h3>
            @foreach ($data->old_values as $key => $value)
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{Str::ucfirst($key)}}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $value }}</p>
                </div>

            @endforeach
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <h3 class="col-span-4 text-2xl font-bold mb-1 text-gray-900 dark:text-white my-4">{{__('Old Datas')}}</h3>
            @if(!empty($data->new_values))

                @foreach ($data->new_values as $key => $value)
                    <div class="col-span-1">
                        <p class="text-gray-500 dark:text-gray-400">{{Str::ucfirst($key)}}</p>
                        <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ $value }}</p>
                    </div>

                @endforeach
            @else
                <div class="col-span-1">
                    <p class="text-gray-500 dark:text-gray-400">{{__('New Values')}}</p>
                    <p class="font-mono font-semibold text-gray-900 dark:text-white uppercase">{{ 'N/A' }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
