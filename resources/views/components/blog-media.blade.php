@props(['file', 'alt'])

@php
    $path = storage_path('app/public/' . $file);
    $type = detectFileType($path);
@endphp

@if ($type === 'image')
    <img src="{{ storage_url($file) }}" class="w-full h-full" alt="{{ $alt }}" title="{{ $alt }}">
@elseif ($type === 'video')
    <video class="w-full h-full" controls playsinline preload="metadata">
        <source src="{{ storage_url($file) }}" type="video/mp4">
    </video>
@elseif ($type === 'missing')
    <p class="text-red-500">File not found</p>
@else
    <p class="text-red-500">Unsupported file format</p>
@endif
