@props(['pagination' => []])

@if (isset($pagination['last_page']) && $pagination['last_page'] > 1)
    <div class="flex flex-wrap items-center justify-end mt-8 text-sm gap-2">
        {{-- Previous Button --}}
        <button wire:click="previousPage" @if ($pagination['current_page'] <= 1) disabled @endif
            class="px-3 md:px-4 py-2  text-text-white shadow-2xl rounded-lg text-sm hover:bg-bg-primary/60 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
            {{ __('Previous') }}
        </button>
        {{-- Page Numbers --}}
        @php
            $start = max(1, $pagination['current_page'] - 2);
            $end = min($pagination['last_page'], $pagination['current_page'] + 2);

            // Adjust if at the beginning or end
            if ($pagination['current_page'] <= 3) {
                $end = min(5, $pagination['last_page']);
            }
            if ($pagination['current_page'] > $pagination['last_page'] - 3) {
                $start = max(1, $pagination['last_page'] - 4);
            }
        @endphp
        {{-- First Page --}}
        @if ($start > 1)
            <button wire:click="gotoPage(1)"
                class="px-3 md:px-4 py-2  text-text-white shadow-2xl rounded-lg text-sm hover:bg-bg-primary/60 transition-colors">
                1
            </button>
            @if ($start > 2)
                <span class="px-2 text-text-muted">...</span>
            @endif
        @endif

        {{-- Page Range --}}
        @for ($i = $start; $i <= $end; $i++)
            <button wire:click="gotoPage({{ $i }})"
                class="px-3 md:px-4 py-2 @if ($i == $pagination['current_page']) bg-zinc-500 text-white font-semibold shadow-lg shadow-primary-900/50 @else  text-text-white shadow-2xl hover:bg-bg-primary/60 @endif rounded-lg text-sm transition-colors">
                {{ $i }}
            </button>
        @endfor
        {{-- Last Page --}}
        @if ($end < $pagination['last_page'])
            @if ($end < $pagination['last_page'] - 1)
                <span class="px-2 text-text-muted">...</span>
            @endif
            <button wire:click="gotoPage({{ $pagination['last_page'] }})"
                class="px-3 md:px-4 py-2  text-text-white shadow-2xl rounded-lg text-sm hover:bg-bg-primary/60 transition-colors">
                {{ $pagination['last_page'] }}
            </button>
        @endif
        {{-- Next Button --}}
        <button wire:click="nextPage" @if ($pagination['current_page'] >= $pagination['last_page']) disabled @endif
            class="px-3 md:px-4 py-2  text-text-white shadow-2xl rounded-lg text-sm hover:bg-bg-primary/60 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
            {{ __('Next') }}
        </button>
    </div>

    {{-- Showing X to Y of Z results
    <div class="text-center mt-4 text-sm text-text-muted">
        Showing {{ $pagination['from'] }} to {{ $pagination['to'] }} of {{ $pagination['total'] }} results
    </div> --}}
@endif
