@props([
    'disabled' => false,
    'rows' => 3,
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
])

<textarea {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {{ $required ? 'required' : '' }}
    rows="{{ $rows }}" placeholder="{{ $placeholder }}" {!! $attributes->merge([
        'class' =>
            'w-full shadow-sm px-3 py-2 bg-transparent dark:bg-transparent dark:text-zinc-100 text-zinc-900 rounded-md border border-zinc-300 focus:border-accent focus:ring-accent focus:ring-1 disabled:opacity-50 disabled:cursor-not-allowed readonly:opacity-50 readonly:cursor-not-allowed transition duration-150 bg-white placeholder-zinc-400 focus:outline-none focus:ring-offset-0 resize-y',
    ]) !!}>{{ $slot }}</textarea>
