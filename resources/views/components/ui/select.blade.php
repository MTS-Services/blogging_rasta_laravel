@props([
    'disabled' => false,
    'append' => null,
    'multiple' => false,
    'placeholder' => 'Choose an option',
    'tags' => false,
    'allowClear' => true,
])

{{-- Check if $append prop is provided (using null default instead of isset) --}}
@if (is_null($append))
    {{-- STANDARD SELECT INPUT --}}
    <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            // DaisyUI 'select' class
            'select w-full !border-zinc-300 focus:!border-accent focus:!outline-none focus:!ring-1 focus:!ring-accent shadow-sm dark:border-zinc-700 bg-transparent! dark:text-zinc-100! text-zinc-900 dark:focus:border-accent dark:focus:ring-accent !transition-all !duration-300 !ease-in-out',
    ]) !!}>
        {{ $slot }}
    </select>
@else
    <div class="flex items-center w-full">
        <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' =>
                // DaisyUI 'select' class + remove rounded right corner
                'select select-bordered rounded-r-none w-full !border-zinc-300 focus:!border-accent focus:!ring-1 focus:!ring-accent shadow-sm dark:border-zinc-700 bg-transparent! dark:text-zinc-100! text-zinc-900 dark:focus:border-accent dark:focus:ring-accent !transition-all !duration-300 !ease-in-out',
        ]) !!}>
            {{ $slot }}
        </select>

        {{-- Appended Span (Modernized to fit the select height and style) --}}
        <span
            class="inline-flex items-center h-12 -ml-px px-4 text-sm font-medium border border-l-0 border-zinc-300 rounded-r-md bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:border-zinc-700 dark:text-zinc-300">
            {{ $append }}
        </span>
    </div>
@endif

@push('scripts')
    <script>
        // Initialize on Livewire navigation
        document.addEventListener("livewire:navigated", () => {
            initializeSelect2({
                placeholder: "{{ $placeholder }}",
                multiple: {{ $multiple ? 'true' : 'false' }},
                tags: {{ $tags ? 'true' : 'false' }},
                allowClear: {{ $allowClear ? 'true' : 'false' }},
            });
        });

        // Initialize on page load
        document.addEventListener("livewire:initialized", () => {
            initializeSelect2({
                placeholder: "{{ $placeholder }}",
                multiple: {{ $multiple ? 'true' : 'false' }},
                tags: {{ $tags ? 'true' : 'false' }},
                allowClear: {{ $allowClear ? 'true' : 'false' }},
            });
        });

        // Re-initialize after DOM morphing
        // Livewire.hook('morph.updated', ({
        //     el
        // }) => {
        //     if (el.matches('select.select2') || el.querySelector('select.select2')) {
        //         initializeSelect2({
        //             placeholder: "{{ $placeholder }}",
        //             multiple: {{ $multiple ? 'true' : 'false' }},
        //             tags: {{ $tags ? 'true' : 'false' }},
        //             allowClear: {{ $allowClear ? 'true' : 'false' }},
        //         });
        //     }
        // });
    </script>
@endpush
