@php $attributes = $unescapedForwardedAttributes ?? $attributes; @endphp
@props([
    'name' => null,
    'variant' => 'regular',
])

@php
    // Map Flux variants to Phosphor styles
    $phosphorStyle = match ($variant) {
        'outline' => '', // regular is default, no suffix
        'solid' => '-fill',
        'mini' => '-bold',
        'micro' => '-bold',
        'regular' => '',
        'bold' => '-bold',
        'fill' => '-fill',
        'light' => '-light',
        'thin' => '-thin',
        'duotone' => '-duotone',
        default => '',
    };

    $classes = Flux::classes('shrink-0')->add(
        match ($variant) {
            'outline', 'regular' => '[:where(&)]:size-6',
            'solid', 'fill' => '[:where(&)]:size-6',
            'mini', 'bold' => '[:where(&)]:size-5',
            'micro' => '[:where(&)]:size-4',
            default => '[:where(&)]:size-6',
        },
    );

    // Blade Phosphor Icons naming: phosphor-{name} or phosphor-{name}-{style}
    $iconComponent = "phosphor-{$name}{$phosphorStyle}";
@endphp

<x-dynamic-component :component="$iconComponent" {{ $attributes->class($classes) }} data-flux-icon aria-hidden="true" />
