@props(['file'])

@php
    $path = storage_path('app/public/' . $file);
    $type = detectFileType($path);
@endphp
@if(isset($type))
    @if ($type === 'image')
        <img src="{{ storage_url($file) }}" class="w-full h-full " alt="">
    @endif

    @if ($type === 'video')
        <video class="w-full h-full " controls playsinline preload="metadata">
            <source src="{{ storage_url($file) }}" type="video/mp4">
        </video>
    @endif
    @if ($type === 'unknown')
        <p class="text-red-500">Unsupported file format</p>
    @endif
@else
    <p class="text-red-500">Unsupported file format</p>
@endif
