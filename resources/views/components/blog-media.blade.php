@props(['file', 'alt', 'eager' => false])

@if (empty($file))
    <div class="w-full aspect-video bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-500 rounded-lg">
        <span class="text-sm">{{ $alt ?? 'No media' }}</span>
    </div>
@else
@php
    $path = storage_path('app/public/' . $file);
    $type = detectFileType($path);
@endphp

@if ($type === 'image')
    <img src="{{ storage_url($file) }}" class="w-full h-full object-cover" alt="{{ $alt }}" title="{{ $alt }}" loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async" fetchpriority="{{ $eager ? 'high' : 'auto' }}">
@elseif ($type === 'video')
    <video class="w-full h-full" controls playsinline preload="metadata">
        <source src="{{ storage_url($file) }}" type="video/mp4">
    </video>
@elseif ($type === 'missing')
    <p class="text-red-500">File not found</p>
@else
    <p class="text-red-500">Unsupported file format</p>
@endif
@endif
