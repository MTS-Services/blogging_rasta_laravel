@props([
    'columns' => [],
    'data' => [],
    'actions' => [],
    'emptyMessage' => 'No records found.',
])

<div class="overflow-x-auto bg-bg-primary">
    <table class="w-full text-left table-auto border-separate border-spacing-0">
        <thead>
            <tr class="text-sm text-text-white bg-bg-secondary/80! uppercase tracking-wider">
                @foreach ($columns as $column)
                    <th class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                        @if (isset($column['sortable']) && $column['sortable'])
                            <div class="flex items-center gap-1">
                                {{ __($column['label']) }}
                                <div>
                                    <x-phosphor-caret-up-fill class="w-4 h-4 fill-zinc-500" />
                                    <x-phosphor-caret-down-fill class='w-4 h-4' />
                                </div>
                            </div>
                        @else
                            {{ __($column['label']) }}
                        @endif
                    </th>
                @endforeach

                @if (count($actions) > 0)
                    <th class="px-2 sm:px-4 md:px-6 py-5 text-sm md:text-base text-text-white capitalize font-normal">
                        {{ __('Actions') }}
                    </th>
                @endif
            </tr>
        </thead>

        <tbody class="divide-y divide-zinc-800">
            @forelse ($data as $index => $item)
                <tr class="{{ $index % 2 === 0 ? 'bg-bg-primary' : 'bg-bg-secondary' }} hover:bg-bg-hover transition-colors">
                    @foreach ($columns as $column)
                        <td class="px-2 sm:px-4 md:px-6 py-4 text-text-white text-xs sm:text-sm">
                            @if (isset($column['format']) && is_callable($column['format']))
                                {{-- Custom Format Function - --}}
                                {!! $column['format']($item) !!}
                            @elseif (isset($column['badge']) && $column['badge'])
                                {{-- Badge Style --}}
                                @php
                                    $value = data_get($item, $column['key']);
                                    $badgeColors = $column['badgeColors'] ?? [
                                        'active' => 'bg-pink-500',
                                        'paused' => 'bg-red-500',
                                        'inactive' => 'bg-gray-500',
                                    ];
                                    $badgeColor = $badgeColors[strtolower($value)] ?? 'bg-gray-500';
                                @endphp
                                <span class="px-2 xxs:px-3 py-1 text-xs font-semibold rounded-full {{ $badgeColor }} text-white whitespace-nowrap inline-block">
                                    {{ ucfirst($value) }}
                                </span>
                            @else
                                {{-- Default Text Display --}}
                                <span class="text-text-white text-xs sm:text-sm">
                                    {{ data_get($item, $column['key']) ?? '-' }}
                                </span>
                            @endif
                        </td>
                    @endforeach

                    @if (count($actions) > 0)
                        <td class="px-2 sm:px-4 md:px-6 py-3">
                            <div class="flex items-center gap-3 text-text-muted">
                                @foreach ($actions as $action)
                                    @php
                                        $actionValue = data_get($item, $action['param'] ?? 'id');
                                        $isActive = isset($action['condition']) ? $action['condition']($item) : true;
                                        $iconName = $action['icon'] ?? 'question-mark';
                                        $componentName = 'phosphor-' . $iconName;
                                    @endphp

                                    @if ($isActive)
                                        @if (isset($action['method']))
                                            <button type="button"
                                                    wire:click="{{ $action['method'] }}({{ is_numeric($actionValue) ? $actionValue : "'{$actionValue}'" }})"
                                                    class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors"
                                                    title="{{ $action['label'] ?? '' }}">
                                                <x-dynamic-component :component="$componentName" class="w-5 h-5" />
                                            </button>
                                        @elseif (isset($action['route']))
                                            <a href="{{ route($action['route'], $actionValue) }}"
                                               wire:navigate
                                               class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors"
                                               title="{{ $action['label'] ?? '' }}">
                                                <x-dynamic-component :component="$componentName" class="w-5 h-5" />
                                            </a>
                                        @elseif (isset($action['href']))
                                            <a href="{{ $action['href'] }}"
                                               target="{{ $action['target'] ?? '_self' }}"
                                               class="cursor-pointer hover:{{ $action['hoverClass'] ?? 'text-text-primary' }} transition-colors"
                                               title="{{ $action['label'] ?? '' }}">
                                                <x-dynamic-component :component="$componentName" class="w-5 h-5" />
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) + (count($actions) > 0 ? 1 : 0) }}"
                        class="px-4 py-12 text-center text-text-muted">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <svg class="w-12 h-12 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-lg font-medium">{{ $emptyMessage }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
